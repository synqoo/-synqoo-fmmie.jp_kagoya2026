<?php
/**
 * Formz 自動返信メール（登録成功後の入力者向けなど）
 *
 * 旧 synqoomail()（functions.php）との関係:
 * - Content-Type が ISO-2022-JP なのに本文を SJIS にしているなど、ヘッダと実体の整合が取りにくい
 * - 送信後に echo で宛先・件名・本文を出力しており、Web 応答に混ざる（本番では不適切）
 * - mb_internal_encoding をグローバルに切り替えるだけで、呼び出し元への影響を抑える処理がない
 *
 * 上記のため、自動返信は本ファイルの formz_mail_send_plain_utf8() で送る。
 * synqoomail() 自体の改修は必須ではない（他コードが未使用なら放置可。再利用する場合は echo 削除とエンコーディング整理を推奨）。
 */

/**
 * プレーンテキストメールを UTF-8 で送信する（mb_send_mail / mb_language=uni）
 *
 * @param string $to              宛先（1 アドレス）
 * @param string $subject       件名
 * @param string $body          本文
 * @param string $envelopeFrom  Envelope From（-f、未送信時は noreply@fmmie.jp）
 * @param string $fromDisplayName From 表示名（空ならアドレスのみ）
 * @return bool                 成功時 true（mb_send_mail の戻り値）
 */
function formz_mail_send_plain_utf8($to, $subject, $body, $envelopeFrom = 'noreply@fmmie.jp', $fromDisplayName = 'fmMIE') {
	$to = trim((string) $to);
	if ($to === '' || filter_var($to, FILTER_VALIDATE_EMAIL) === false) {
		return false;
	}
	$subject = (string) $subject;
	$body = (string) $body;
	if ($subject === '') {
		return false;
	}

	$envelopeFrom = trim((string) $envelopeFrom);
	if ($envelopeFrom === '' || filter_var($envelopeFrom, FILTER_VALIDATE_EMAIL) === false) {
		return false;
	}

	$prevLang = mb_language();
	$prevEnc = mb_internal_encoding();

	mb_language('uni');
	mb_internal_encoding('UTF-8');

	$fromDisplayName = (string) $fromDisplayName;
	if ($fromDisplayName !== '') {
		$fromLine = mb_encode_mimeheader($fromDisplayName, 'UTF-8', 'B') . ' <' . $envelopeFrom . '>';
	} else {
		$fromLine = $envelopeFrom;
	}

	$messageId = '<' . bin2hex(random_bytes(16)) . '@fmmie.jp>';
	$headers = implode("\r\n", array(
		'MIME-Version: 1.0',
		'Content-Type: text/plain; charset=UTF-8',
		'Content-Transfer-Encoding: 8bit',
		'From: ' . $fromLine,
		'Message-ID: ' . $messageId,
	));

	$params = '-f ' . $envelopeFrom;
	$ok = mb_send_mail($to, $subject, $body, $headers, $params);

	if ($prevLang !== false) {
		mb_language($prevLang);
	}
	if ($prevEnc !== false) {
		mb_internal_encoding($prevEnc);
	}

	return $ok;
}
