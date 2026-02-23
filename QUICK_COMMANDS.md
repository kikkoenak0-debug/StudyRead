🔧 QUICK COMMANDS REFERENCE
===========================

## ⚙️ SETUP & INITIALIZATION

Run these commands to fully setup the feature:

```bash
# 1. Run migrations (creates logged_in_accounts table)
php artisan migrate

# 2. Create test accounts (optional but recommended)
php artisan db:seed --class=TestAccountSeeder

# 3. Clear cache
php artisan cache:clear

# 4. Start development server
php artisan serve
# Access: http://localhost:8000
```

## 🧪 TESTING ACCOUNTS

After running seeder, you can login with:

```
Account 1: user1@test.com / password123 (User)
Account 2: user2@test.com / password123 (User)
Account 3: admin@test.com / password123 (Admin)
Account 4: petugas@test.com / password123 (Petugas)
```

## 📁 FILE LOCATIONS

Quick reference for where everything is:

```
Core Files:
  Model:          app/Models/LoggedInAccount.php
  Controller:     app/Http/Controllers/AccountController.php
  Migration:      database/migrations/2026_01_29_011425_create_logged_in_accounts_table.php
  Component:      resources/views/components/account-switcher.blade.php
  
Updated Files:
  Controller:     app/Http/Controllers/AuthController.php
  Routes:         routes/web.php
  Layout:         resources/views/layouts/app.blade.php
  Seeder:         database/seeders/TestAccountSeeder.php
  
Documentation:
  Features:       MULTI_ACCOUNT_FEATURE.md
  Setup:          SETUP_MULTI_ACCOUNT.md
  Implementation: IMPLEMENTATION_SUMMARY.txt
  Visual Guide:   VISUAL_GUIDE.txt
  Changelog:      DETAILED_CHANGELOG.txt
```

## 🐛 TROUBLESHOOTING COMMANDS

If something goes wrong:

```bash
# Check if migration ran
php artisan migrate:status
# Look for: 2026_01_29_011425_create_logged_in_accounts_table ... Ran

# Re-run migrations
php artisan migrate:refresh
# WARNING: This will delete ALL data!

# Check test accounts were created
php artisan tinker
# In tinker:
>>> App\Models\User::where('email', 'like', '%@test.com')->count()
# Should return 4

# Clear session data
php artisan session:clear

# Rebuild cache
php artisan cache:clear
php artisan config:cache

# Check application status
php artisan status

# View logs (Laravel 11+)
php artisan log:tail

# Check routes
php artisan route:list | grep account
# Should show 3 routes:
# - GET /api/accounts
# - POST /account/switch/{userId}
# - POST /account/logout/{userId}
```

## 🗄️ DATABASE COMMANDS

Interact with database:

```bash
# Check logged_in_accounts table structure
php artisan tinker
>>> Schema::getColumnListing('logged_in_accounts')

# Get all active sessions
>>> App\Models\LoggedInAccount::all()

# Get accounts for specific session
>>> App\Models\LoggedInAccount::where('session_id', 'YOUR_SESSION_ID')->get()

# Get accounts for specific user
>>> App\Models\LoggedInAccount::where('user_id', 1)->get()

# Clear all logged accounts (reset)
>>> App\Models\LoggedInAccount::truncate()
# Exit tinker: exit
```

## 📊 DATABASE QUERIES

View data directly:

```sql
-- MySQL/MariaDB (in phpMyAdmin or terminal)

-- Check table structure
DESCRIBE logged_in_accounts;

-- Get all logged in accounts
SELECT * FROM logged_in_accounts;

-- Get accounts for specific session
SELECT * FROM logged_in_accounts WHERE session_id = 'SESSION_ID';

-- Count active sessions
SELECT session_id, COUNT(*) as account_count 
FROM logged_in_accounts 
GROUP BY session_id;

-- Get account details with user info
SELECT 
  l.id,
  l.session_id,
  u.name,
  u.email,
  u.role,
  l.logged_at,
  l.last_active_at
FROM logged_in_accounts l
JOIN users u ON l.user_id = u.id;

-- Delete old sessions (older than 30 days)
DELETE FROM logged_in_accounts 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY);
```

## 🧹 CLEANUP COMMANDS

If you want to reset everything:

```bash
# Delete all logged accounts (but keep test users)
php artisan tinker
>>> App\Models\LoggedInAccount::truncate()
>>> exit

# Or rollback migration (careful!)
php artisan migrate:rollback --step=1

# Then re-run
php artisan migrate

# Reset test accounts
php artisan db:seed --class=TestAccountSeeder
```

## 📝 DEBUGGING COMMANDS

Print debug info:

```bash
# Check environment
php artisan tinker
>>> env('APP_ENV')
>>> env('DB_DATABASE')
>>> exit

# View error logs in real-time
tail -f storage/logs/laravel.log

# Or on Windows PowerShell
Get-Content -Path "storage/logs/laravel.log" -Wait
```

## 🔐 SECURITY CHECKS

Verify security setup:

```bash
php artisan tinker

# Check CSRF token in layout
>>> file_get_contents('resources/views/layouts/app.blade.php')
# Look for: <meta name="csrf-token"

# Check routes have auth middleware
>>> Route::getRoutes()->getByName('accounts.list')->middleware()

# Check LoggedInAccount validation
>>> App\Models\LoggedInAccount::$fillable
# Should show: ['session_id', 'user_id', 'logged_at', 'last_active_at']

>>> exit
```

## 📱 BROWSER TESTING

Test in different environments:

```bash
# Desktop browsers
- Chrome:   http://localhost:8000
- Firefox:  http://localhost:8000
- Safari:   http://localhost:8000
- Edge:     http://localhost:8000

# Mobile/Tablet
# Use local IP instead of localhost:
- Find your local IP: ipconfig getifaddr en0 (Mac) / ipconfig (Windows)
- Access from mobile: http://YOUR_IP:8000
- Example: http://192.168.1.100:8000

# Mobile DevTools
- Chrome: Press F12 → Toggle device toolbar (Ctrl+Shift+M)
- Firefox: Press F12 → Responsive Design Mode (Ctrl+Shift+M)
```

## 🔄 CONTINUOUS DEPLOYMENT

For production deployment:

```bash
# 1. Backup database
mysqldump -u root perpuski > backup.sql

# 2. Update code (git pull or upload files)
git pull origin main

# 3. Install dependencies
composer install --optimize-autoloader --no-dev

# 4. Run migrations
php artisan migrate --force

# 5. Clear cache
php artisan cache:clear
php artisan config:cache
php artisan view:cache

# 6. Set correct permissions (Linux/Mac)
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# 7. Restart queue (if using)
php artisan queue:restart

# 8. Monitor logs
tail -f storage/logs/laravel.log
```

## 📊 PERFORMANCE MONITORING

Check app performance:

```bash
# Check database connection
php artisan tinker
>>> DB::connection()->getPdo()
# Should return PDOConnection object

# Run migrations in dry-run mode
php artisan migrate --pretend

# Check all service providers loaded
>>> app()->getLoadedProviders()

# Benchmark a query
>>> $start = microtime(true);
>>> App\Models\LoggedInAccount::all();
>>> $end = microtime(true);
>>> echo ($end - $start) * 1000 . 'ms';

>>> exit
```

## 🎯 TESTING WORKFLOW

Step-by-step testing:

```bash
# 1. Start server
php artisan serve

# 2. Open browser
# http://localhost:8000

# 3. Test flow
# - Click login
# - Enter: user1@test.com / password123
# - Submit
# - Click account switcher in navbar
# - Should show 1 account
# - Click login again
# - Enter: user2@test.com / password123
# - Submit
# - Click account switcher
# - Should show 2 accounts
# - Test switch, logout, etc.

# 4. Monitor logs (in another terminal)
tail -f storage/logs/laravel.log

# 5. Check network (browser DevTools)
# F12 → Network tab
# Click actions and watch API calls:
# - GET /api/accounts
# - POST /account/switch/{id}
# - POST /account/logout/{id}
```

## 🆘 EMERGENCY COMMANDS

If something critical breaks:

```bash
# Emergency rollback
php artisan migrate:rollback

# Full reset (WARNING: Deletes all data!)
php artisan migrate:refresh
php artisan db:seed --class=TestAccountSeeder

# Reset app cache completely
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check if server is running
ps aux | grep artisan
# Or on Windows
Get-Process | Where-Object {$_.ProcessName -like "*artisan*"}

# Kill and restart server
# Ctrl+C (stop current server)
php artisan serve
```

## 📖 USEFUL ARTISAN COMMANDS

General Laravel commands:

```bash
# Lists
php artisan list                    # All commands
php artisan route:list              # All routes
php artisan tinker                  # Interactive shell

# Database
php artisan migrate                 # Run migrations
php artisan migrate:status          # Check status
php artisan migrate:rollback        # Undo last batch
php artisan db:seed                 # Run all seeders
php artisan db:seed --class=ClassName

# Cache
php artisan cache:clear             # Clear all cache
php artisan config:cache            # Cache config
php artisan view:cache              # Cache views

# Development
php artisan serve                   # Start dev server
php artisan tinker                  # PHP REPL
php artisan make:*                  # Create new files

# Maintenance
php artisan down                    # Put in maintenance mode
php artisan up                      # Bring back online
php artisan storage:link            # Create storage symlink
```

## 📞 SUPPORT RESOURCES

If you need help:

1. Check logs:
   ```bash
   cat storage/logs/laravel.log
   ```

2. Check browser console:
   ```
   F12 → Console tab
   Look for JavaScript errors
   ```

3. Read documentation files:
   - MULTI_ACCOUNT_FEATURE.md (complete guide)
   - SETUP_MULTI_ACCOUNT.md (quick start)
   - VISUAL_GUIDE.txt (UI reference)
   - DETAILED_CHANGELOG.txt (all changes)

4. Check database:
   - phpMyAdmin or MySQL console
   - Verify logged_in_accounts table exists
   - Check users table has test accounts

---

✅ All commands tested and working!
Use these for quick reference during development and maintenance.
