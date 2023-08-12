<?php

$userUrl = isset($_GET['url']) ? $_GET['url'] : '/';
$userUrl = substr($userUrl, -1) != '/' ? $userUrl . '/' : $userUrl;

$pages = [
    "/" => "controllers/anasayfa.php",
    "/iletisim/" => "controllers/iletisim.php",
    "/profil/{username}/" => "controllers/profil.php",

    "404" => "controllers/404.php"
];

$matchedPage = null;
$matchedVariables = [];

foreach ($pages as $pagePattern => $viewFile) {
    $pattern = str_replace(['{', '}'], ['(?P<', '>[^/]+)'], $pagePattern);
    $pattern = str_replace('/', '\/', $pattern);

    if (preg_match('/^' . $pattern . '$/', $userUrl, $matches)) {
        $matchedPage = $viewFile;
        $matchedVariables = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        break;
    }
}

if ($matchedPage) {
    require_once $matchedPage;
} else {
    require_once $pages["404"];
}
