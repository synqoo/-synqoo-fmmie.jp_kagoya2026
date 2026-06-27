<?php
/**
 * fmmie.jp → Kagoya formin 投稿リレー（doc 24 経路 1 の PHP 版）
 *
 * formz_regist.php から 1 回呼ぶ。失敗しても呼び出し元のフローは止めない。
 * 動作環境: PHP 7.3+（arrow function / never / mixed 禁止）
 */

declare(strict_types=1);

if (! function_exists('formin_regist')) {

    /**
     * @param array<string, mixed> $post
     */
    function formin_regist(array $post): void
    {
        static $relayReady = null;

        if ($relayReady === null) {
            $relayReady = false;
            $configFile = __DIR__ . '/formin_config.php';
            if (is_file($configFile)) {
                require_once $configFile;
            }
            if (
                defined('FORMIN_RELAY_ENABLED')
                && FORMIN_RELAY_ENABLED
                && defined('FORMIN_RELAY_URL')
                && trim((string) FORMIN_RELAY_URL) !== ''
                && defined('FORMIN_MIRROR_API_KEY')
            ) {
                $key = (string) FORMIN_MIRROR_API_KEY;
                if ($key !== '' && $key !== 'CHANGE_ME') {
                    $relayReady = true;
                }
            }
        }

        if (! $relayReady) {
            return;
        }

        $formId = isset($post['form_id']) ? (int) $post['form_id'] : 0;
        if ($formId <= 0) {
            return;
        }

        $payload = formin_regist_build_payload($post, $formId);
        if ($payload === null) {
            return;
        }

        $timeout = defined('FORMIN_RELAY_TIMEOUT_SEC') ? (int) FORMIN_RELAY_TIMEOUT_SEC : 5;
        if ($timeout < 1) {
            $timeout = 5;
        }

        $url = (string) FORMIN_RELAY_URL;
        $key = (string) FORMIN_MIRROR_API_KEY;
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            error_log('[formin_regist] json_encode failed form_id=' . $formId);

            return;
        }

        $responseBody = formin_regist_http_post($url, $key, $json, $timeout);
        if ($responseBody === false) {
            error_log('[formin_regist] relay failed form_id=' . $formId);

            return;
        }

        $decoded = json_decode($responseBody, true);
        if (! is_array($decoded) || ($decoded['status'] ?? '') !== 'ok') {
            error_log('[formin_regist] unexpected response form_id=' . $formId . ' body=' . substr($responseBody, 0, 200));
        }
    }

    /**
     * @param array<string, mixed> $post
     * @return array<string, mixed>|null
     */
    function formin_regist_build_payload(array $post, int $formId): ?array
    {
        static $columns = [
            'number', 'id', 'form_id', 'program_id', 'u_name', 'u_kana', 'u_radioname', 'u_sex', 'u_age', 'u_zip', 'u_pref',
            'u_address', 'u_address2', 'u_address3', 'u_tel', 'u_tel2', 'u_email', 'u_present', 'r_artist', 'r_songtitle',
            'r_message', 'r_attached', 'u_body', 'x_fld1', 'x_fld2', 'x_fld3', 'x_fld4', 'x_fld5', 'x_sel', 'x_bt', 'x_prez',
            'p_name1', 'p_kana1', 'p_age1', 'p_sex1', 'p_con1', 'p_name2', 'p_kana2', 'p_age2', 'p_sex2', 'p_con2',
            'p_name3', 'p_kana3', 'p_age3', 'p_sex3', 'p_con3', 'p_name4', 'p_kana4', 'p_age4', 'p_sex4', 'p_con4',
            'p_name5', 'p_kana5', 'p_age5', 'p_sex5', 'p_con5', 'u_date', 'u_agent', 'u_ip', 'u_date2', 'a_admin', 'a_check',
            'a_memo', 'a_test', 'a_state', 'a_cat', 'a_present', 'a_fax', 'a_new', 'a_reply',
        ];

        $payload = [];

        foreach ($columns as $col) {
            if ($col === 'number') {
                if (isset($post['number']) && (int) $post['number'] > 0) {
                    $payload['number'] = (int) $post['number'];
                }
                continue;
            }
            if ($col === 'form_id') {
                $payload['form_id'] = $formId;
                continue;
            }
            if ($col === 'program_id') {
                $payload['program_id'] = isset($post['program_id']) ? (int) $post['program_id'] : 0;
                continue;
            }
            if (array_key_exists($col, $post)) {
                $payload[$col] = is_scalar($post[$col]) || $post[$col] === null
                    ? (string) $post[$col]
                    : '';
            }
        }

        if (! isset($payload['u_date']) || trim((string) $payload['u_date']) === '') {
            $payload['u_date'] = date('Y-m-d H:i:s');
        }

        if (! isset($payload['u_agent']) || trim((string) $payload['u_agent']) === '') {
            $payload['u_agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? (string) $_SERVER['HTTP_USER_AGENT'] : '';
        }

        if (! isset($payload['u_ip']) || trim((string) $payload['u_ip']) === '') {
            $payload['u_ip'] = isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
        }

        if (! isset($payload['a_test'])) {
            $email = isset($payload['u_email']) ? (string) $payload['u_email'] : '';
            $payload['a_test'] = ($email === 'synqoo@fmmie.co.jp') ? '1' : '0';
        }

        return $payload;
    }

    function formin_regist_http_post(string $url, string $apiKey, string $jsonBody, int $timeout)
    {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            if ($ch === false) {
                return false;
            }

            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $jsonBody,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json; charset=UTF-8',
                    'X-Formz-Mirror-Key: ' . $apiKey,
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => $timeout,
                CURLOPT_CONNECTTIMEOUT => min(3, $timeout),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
            ]);

            $body = curl_exec($ch);
            $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($body === false || ($httpCode !== 200 && $httpCode !== 0)) {
                return false;
            }

            return $body;
        }

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json; charset=UTF-8\r\n"
                    . 'X-Formz-Mirror-Key: ' . $apiKey . "\r\n",
                'content' => $jsonBody,
                'timeout' => $timeout,
                'ignore_errors' => true,
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);

        $body = @file_get_contents($url, false, $context);
        if ($body === false) {
            return false;
        }

        return $body;
    }
}
