<?php
function err($error, $message) {
    echo sprintf(
        '<p>%s:</p><code style="background:#eee;border:1px solid #ccc;padding:10px;">%s</code>',
        htmlspecialchars($error),
        htmlspecialchars($message)
    );
}

echo '<h1>PHP &mdash; Hello World!</h1>';

// no service binded
if (false === $uri = getenv('MYSQL_URI')) {
    echo '<p>There are no binded services, try binding one in the console.</p>';
    exit();
}

// MySQL service binded :)
$dsn = sprintf(
    'mysql:host=%s;dbname=%s;port=%d',
    parse_url($uri, PHP_URL_HOST),
    substr(parse_url($uri, PHP_URL_PATH), 1),
    parse_url($uri, PHP_URL_PORT)
);
$username = parse_url($uri, PHP_URL_USER);
$password = parse_url($uri, PHP_URL_PASS);

try {
    $db = new \PDO($dsn, $username, $password);
    echo 'Successfully connected to MySQL!';
} catch (\PDOException $e) {
    err('MySQL connection failed', $e->getMessage());
} catch (\Exception $e) {
    err('Unexpected error', $e->getMessage());
}
