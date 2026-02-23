<!-- Account Switcher Component -->
<div class="account-switcher-container">
    <style>
        .account-switcher-container {
            position: relative;
            display: inline-block;
        }

        .account-switcher-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .account-switcher-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .account-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            overflow: hidden;
        }

        .account-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .account-name {
            display: none;
        }

        @media (min-width: 768px) {
            .account-name {
                display: block;
                max-width: 120px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }

        .account-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            margin-top: 8px;
            min-width: 280px;
            z-index: 1000;
        }

        .account-dropdown.show {
            display: block;
        }

        .dropdown-header {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dropdown-content {
            max-height: 300px;
            overflow-y: auto;
        }

        .account-item {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background-color 0.2s;
            border-bottom: 1px solid #f5f5f5;
        }

        .account-item:last-child {
            border-bottom: none;
        }

        .account-item:hover {
            background-color: #f9f9f9;
        }

        .account-item.active {
            background-color: #f0f7ff;
        }

        .account-item-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .account-item-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .account-item-info {
            flex: 1;
            min-width: 0;
        }

        .account-item-name {
            font-weight: 500;
            color: #333;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .account-item-email {
            font-size: 12px;
            color: #999;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .account-item-role {
            font-size: 11px;
            color: #667eea;
            font-weight: 600;
            text-transform: capitalize;
            padding: 2px 6px;
            background-color: #f0f4ff;
            border-radius: 3px;
            margin-top: 2px;
            display: inline-block;
        }

        .account-item-active {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            flex-shrink: 0;
        }

        .account-item.active .account-item-active::before {
            content: '✓';
        }

        .dropdown-footer {
            padding: 12px 16px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            gap: 8px;
        }

        .btn-logout-all {
            flex: 1;
            padding: 8px 12px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s;
            color: #333;
        }

        .btn-logout-all:hover {
            background-color: #eee;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #999;
            font-size: 13px;
        }

        .error-message {
            padding: 12px 16px;
            background-color: #fee;
            color: #c00;
            font-size: 13px;
            border-radius: 4px;
        }

        .account-item-remove-btn {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: none;
            background-color: #f0f0f0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            transition: all 0.2s;
            font-size: 16px;
            flex-shrink: 0;
        }

        .account-item-remove-btn:hover {
            background-color: #e0e0e0;
            color: #333;
        }
    </style>

    @auth
    <button class="account-switcher-btn" id="accountSwitcherBtn">
        <div class="account-avatar">
            @if(auth()->user()->foto)
                <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="{{ auth()->user()->name }}">
            @else
                {{ substr(auth()->user()->name, 0, 1) }}
            @endif
        </div>
        <span class="account-name">{{ auth()->user()->name }}</span>
        <span style="font-size: 12px;">▼</span>
    </button>

    <div class="account-dropdown" id="accountDropdown">
        <div class="dropdown-header">Akun Aktif</div>
        <div class="dropdown-content" id="accountsList">
            <div class="loading">Memuat akun...</div>
        </div>
        <div class="dropdown-footer">
            <button class="btn-logout-all" onclick="logoutAllAccounts()">Logout Semua</button>
        </div>
    </div>
    @endauth
</div>

<script>
    const accountSwitcherBtn = document.getElementById('accountSwitcherBtn');
    const accountDropdown = document.getElementById('accountDropdown');
    const accountsList = document.getElementById('accountsList');

    // Toggle dropdown
    if (accountSwitcherBtn) {
        accountSwitcherBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            accountDropdown.classList.toggle('show');
            if (accountDropdown.classList.contains('show')) {
                loadAccounts();
            }
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.account-switcher-container')) {
            accountDropdown.classList.remove('show');
        }
    });

    // Load accounts
    function loadAccounts() {
        fetch('/api/accounts')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderAccounts(data.accounts);
                }
            })
            .catch(error => {
                accountsList.innerHTML = '<div class="error-message">Gagal memuat akun</div>';
            });
    }

    // Render accounts
    function renderAccounts(accounts) {
        if (accounts.length === 0) {
            accountsList.innerHTML = '<div class="loading">Tidak ada akun lain yang login</div>';
            return;
        }

        let html = '';
        accounts.forEach(account => {
            const initials = account.name.split(' ').map(n => n[0]).join('').toUpperCase();
            const foto = account.foto ? `{{ asset('storage/') }}/${account.foto}` : null;
            
            html += `
                <div class="account-item ${account.is_active ? 'active' : ''}">
                    <div class="account-item-avatar">
                        ${foto ? `<img src="${foto}" alt="${account.name}">` : initials}
                    </div>
                    <div class="account-item-info" onclick="switchAccount(${account.id})">
                        <div class="account-item-name">${account.name}</div>
                        <div class="account-item-email">${account.email}</div>
                        <div class="account-item-role">${account.role}</div>
                    </div>
                    <div class="account-item-active"></div>
                    <button class="account-item-remove-btn" onclick="logoutAccount(${account.id})" title="Logout">×</button>
                </div>
            `;
        });

        accountsList.innerHTML = html;
    }

    // Switch account
    function switchAccount(userId) {
        fetch(`/account/switch/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Gagal switch akun');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat switch akun');
        });
    }

    // Logout from specific account
    function logoutAccount(userId) {
        if (!confirm('Logout dari akun ini?')) return;

        fetch(`/account/logout/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    loadAccounts();
                }
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan');
        });
    }

    // Logout all accounts
    function logoutAllAccounts() {
        if (!confirm('Logout dari semua akun?')) return;

        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(response => {
            window.location.href = '/';
        });
    }
</script>
