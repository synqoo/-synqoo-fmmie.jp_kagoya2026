<?php
header('Content-Type: application/javascript; charset=UTF-8');
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
?>
(function() {
  'use strict';
  const staticTheme = <?php echo json_encode($staticTheme ?? ''); ?>;
  const validThemes = <?php echo json_encode($validThemes ?? []); ?>;

  if (staticTheme && validThemes.includes(staticTheme)) {
    document.documentElement.setAttribute('data-theme', staticTheme);
  } else {
    document.documentElement.removeAttribute('data-theme');
  }
})();

