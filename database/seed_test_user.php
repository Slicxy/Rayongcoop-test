<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\App;
use App\Core\Database;

$app = new App();

$existing = Database::first('SELECT * FROM users WHERE username = ? OR email = ?', ['rayongcoop1', 'rayongcoop1@rayongcoop.com']);

$hash = password_hash('coop1', PASSWORD_DEFAULT);

if (!$existing) {
    $newId = Database::insert(
        'INSERT INTO users (uuid, name, username, email, password, status, two_factor_enabled, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 0, NOW(), NOW())',
        [
            '550e8400-e29b-41d4-a716-446655440001',
            'เจ้าหน้าที่สหกรณ์ (rayongcoop1)',
            'rayongcoop1',
            'rayongcoop1@rayongcoop.com',
            $hash,
            'active'
        ]
    );
    $role = Database::first("SELECT id FROM roles WHERE slug = 'super_admin' LIMIT 1");
    if ($role && $newId) {
        Database::execute('INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)', [(int)$newId, $role['id']]);
    }
    echo "User rayongcoop1 created with ID: {$newId}\n";
} else {
    Database::execute(
        'UPDATE users SET password = ?, status = "active", two_factor_enabled = 0 WHERE id = ?',
        [$hash, $existing['id']]
    );
    echo "User rayongcoop1 updated with ID: {$existing['id']}\n";
}
