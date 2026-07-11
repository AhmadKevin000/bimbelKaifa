<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Filament\Models\Contracts\FilamentUser;

// Boot Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

header('Content-Type: text/plain');

echo "=== DIAGNOSTIC START ===\n\n";

// 1. Clear OPcache
if (function_exists('opcache_reset')) {
    if (opcache_reset()) {
        echo "OPcache cleared successfully.\n";
    } else {
        echo "OPcache reset returned false (may not be enabled/configured).\n";
    }
} else {
    echo "opcache_reset() function does not exist.\n";
}

// 2. Clear Laravel Cache
try {
    Artisan::call('optimize:clear');
    echo "Artisan optimize:clear executed successfully.\n";
    echo Artisan::output() . "\n";
} catch (\Exception $e) {
    echo "Error running optimize:clear: " . $e->getMessage() . "\n\n";
}

// 3. Check User Class Implementation
$userReflection = new ReflectionClass(User::class);
echo "User class path: " . $userReflection->getFileName() . "\n";
echo "Implements FilamentUser: " . ($userReflection->implementsInterface(FilamentUser::class) ? 'YES' : 'NO') . "\n";
if (method_exists(User::class, 'canAccessPanel')) {
    echo "Method canAccessPanel exists: YES\n";
    // Try executing it with a dummy panel
    try {
        $user = new User();
        $panel = filament()->getPanel('admin');
        echo "canAccessPanel(admin) returns: " . ($user->canAccessPanel($panel) ? 'TRUE' : 'FALSE') . "\n";
    } catch (\Exception $e) {
        echo "Error testing canAccessPanel: " . $e->getMessage() . "\n";
    }
} else {
    echo "Method canAccessPanel exists: NO\n";
}

// 4. Check Database Record
try {
    $admin = User::where('email', 'admin@gmail.com')->first();
    if ($admin) {
        echo "\nAdmin User Found in Database:\n";
        echo "ID: " . $admin->id . "\n";
        echo "Email: " . $admin->email . "\n";
        echo "Role: " . $admin->role . "\n";
    } else {
        echo "\nAdmin User 'admin@gmail.com' NOT found in database.\n";
    }
} catch (\Exception $e) {
    echo "\nDatabase error: " . $e->getMessage() . "\n";
}

echo "\n=== DIAGNOSTIC END ===\n";
