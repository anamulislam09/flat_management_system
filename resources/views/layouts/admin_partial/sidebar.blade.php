<style>
    @media screen and (max-width: 767px) {

        ul,
        li,
        a {
            font-size: 13px !important;
        }
    }

    ul,
    li,
    a {
        font-size: 15px;
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4 p-0">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link bg-success text-center">
        @if (Auth::guard('admin')->user()->role == 0)
            <span class="brand-text font-weight-bold">Super Admin</span>
        @else
            <span class="brand-text font-weight-bold">Admin dashboard</span>
        @endif
    </a>

    <!-- Sidebar -->
    <div class="sidebar mt-3">
        <!-- Category start here -->
        <nav class=" mb-5">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item ">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p> Dashboard </p>
                    </a>

                </li>
                @if (Auth::guard('admin')->user()->role == 0)
                    <li
                        class="nav-item {{ Request::routeIs('client.all') || Request::routeIs('client.edit') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::routeIs('client.all') || Request::routeIs('client.edit') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Clients
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('client.all') }}"
                                    class="nav-link {{ Request::routeIs('client.all') || Request::routeIs('client.edit') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>All Client</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    {{-- expense category start here --}}
                    {{-- <li  class="nav-item {{ Request::routeIs('category.index') || Request::routeIs('category.create') ? 'menu-open' : '' }}">>
                        <a href="{{ route('category.index') }}"
                            class="nav-link {{ Request::routeIs('category.index') || Request::routeIs('category.create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>Expense Category</p>
                        </a>
                    </li> --}}

                    <li
                        class="nav-item {{ Request::routeIs('category.index') || Request::routeIs('category.create') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::routeIs('category.index') || Request::routeIs('category.create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Expense Category
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('category.index') }}"
                                    class="nav-link {{ Request::routeIs('category.index') || Request::routeIs('category.edit') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>All Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('category.create') }}"
                                    class="nav-link {{ Request::routeIs('category.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('client.index') }}"
                            class="nav-link {{ Request::routeIs('client.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>Delete Client Data</p>
                        </a>
                    </li>
                    {{-- expense category ends here --}}
                    {{-- Package route Srtart here --}}
                    <li
                        class="nav-item {{ Request::routeIs('package.all') || Request::routeIs('package.create') || Request::routeIs('package.edit') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::routeIs('package.all') || Request::routeIs('package.create') || Request::routeIs('package.edit') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Packages
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('package.all') }}"
                                    class="nav-link {{ Request::routeIs('package.all') || Request::routeIs('package.edit') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>All packages</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('package.create') }}"
                                    class="nav-link {{ Request::routeIs('package.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    {{-- Package route ends here --}}
                @endif

                @if (Auth::guard('admin')->user()->role == 1)
                    {{-- flat Management ends here --}}
                    <li
                        class="nav-item {{ Request::routeIs('flat.index') || Request::routeIs('flat.create') ? 'menu-open active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Flat Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('flat.create') }}"
                                    class="nav-link {{ Request::routeIs('flat.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>New Flat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('flat.index') }}"
                                    class="nav-link {{ Request::routeIs('flat.index') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>All Flat</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- flat Management ends here --}}

                    {{-- User management start here --}}
                    <li
                        class="nav-item {{ Request::routeIs('users.index') || Request::routeIs('users.create') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                User Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            {{-- <li class="nav-item">
                                <a href="{{ route('users.create') }}" class="nav-link">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Create User</p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}"
                                    class="nav-link {{ Request::routeIs('users.index') ? 'active' : '' }} ">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>All Users</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- User management ends here --}}

                    {{-- Expense management ends here --}}
                    <li
                        class="nav-item {{ Request::routeIs('expense.create') || Request::routeIs('expense-summary.index') || Request::routeIs('expense.voucher.create') ? 'menu-open active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Expense Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('expense.create') }}"
                                    class="nav-link {{ Request::routeIs('expense.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Expense Entry</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('expense-summary.index') }}"
                                    class="nav-link {{ Request::routeIs('expense-summary.index') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Expense Summary</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- Expenses Management start here --}}

                    {{-- Income Management start here --}}
                    <li
                        class="nav-item {{ Request::routeIs('income.create') || Request::routeIs('income.collection') || Request::routeIs('income.collection.index') || Request::routeIs('others.income.create') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Income Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('income.create') }}"
                                    class="nav-link {{ Request::routeIs('income.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Generate Income</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('income.collection') }}"
                                    class="nav-link {{ Request::routeIs('income.collection') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Collection </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('income.collection.index') }}"
                                    class="nav-link {{ Request::routeIs('income.collection.index') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Collection Voucher</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('others.income.create') }}"
                                    class="nav-link {{ Request::routeIs('others.income.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Others Income</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- Income Management start here --}}

                    {{-- Accounts  start here --}}
                    <li
                        class="nav-item {{ Request::routeIs('account.expense.all') || Request::routeIs('ledgerPosting.index') || Request::routeIs('account.expense.index') || Request::routeIs('account.balancesheet') || Request::routeIs('opening.balance.create') || Request::routeIs('income.statement') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>Accounts<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('opening.balance.create') }}"
                                    class="nav-link {{ Request::routeIs('opening.balance.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Opening Balance Entry</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('ledgerPosting.index') }}"
                                    class="nav-link {{ Request::routeIs('ledgerPosting.index') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Ledger Posting </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('account.expense.index') }}"
                                    class="nav-link {{ Request::routeIs('account.expense.index') || Request::routeIs('account.expense.all') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Expense Voucher </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('income.statement') }}"
                                    class="nav-link {{ Request::routeIs('income.statement') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Income Statement </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('account.balancesheet') }}"
                                    class="nav-link {{ Request::routeIs('account.balancesheet') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Balance Sheet </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- Accounts ends here --}}

                    {{-- Report  start here --}}
                    <li
                        class="nav-item {{ Request::routeIs('expenses.month') || Request::routeIs('expenses.year') || Request::routeIs('incomes.month') || Request::routeIs('incomes.year') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>Report<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('expenses.month') }}"
                                    class="nav-link {{ Request::routeIs('expenses.month') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Monthly Expense</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('expenses.year') }}"
                                    class="nav-link {{ Request::routeIs('expenses.year') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Yearly Expense</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('incomes.month') }}"
                                    class="nav-link {{ Request::routeIs('incomes.month') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Monthly Income</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('incomes.year') }}"
                                    class="nav-link {{ Request::routeIs('incomes.year') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Yearly Income</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- Report ends here --}}

                    {{-- All Setup  start here --}}
                    <li
                        class="nav-item {{ Request::routeIs('flat.singlecreate') || Request::routeIs('user.create') || Request::routeIs('expense.setup') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>Setup<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('flat.singlecreate') }}"
                                    class="nav-link {{ Request::routeIs('flat.singlecreate') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Add More Flat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.create') }}"
                                    class="nav-link {{ Request::routeIs('user.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Add More User</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('expense.setup') }}"
                                    class="nav-link {{ Request::routeIs('expense.setup') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Schedule Setup</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- All Setup ends here --}}

                    {{-- All Setup history  start here --}}
                    <li class="nav-item ">
                        <a href="{{ route('expense.setup.history') }}"
                            class="nav-link {{ Request::routeIs('expense.setup.history') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>Setup History
                            </p>
                        </a>
                    </li>

                    {{-- All Vendors mewnu start here --}}
                    <li
                        class="nav-item {{ Request::routeIs('vendor.all') || Request::routeIs('vendor.create') || Request::routeIs('vendor.edit') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>Vendors<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('vendor.create') }}"
                                    class="nav-link {{ Request::routeIs('vendor.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Add New Vendor</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('vendor.all') }}"
                                    class="nav-link {{ Request::routeIs('vendor.all') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>All Vendors</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- All Vendors mewnu start here --}}
                    <li
                        class="nav-item {{ Request::routeIs('guestBook.index') || Request::routeIs('guestBook.create') || Request::routeIs('guestBook.edit') || Request::routeIs('guestBook.history') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::routeIs('guestBook.index') || Request::routeIs('guestBook.create') || Request::routeIs('guestBook.edit') || Request::routeIs('guestBook.history') ? 'Active' : '' }}">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>Guest Manage<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('guestBook.create') }}"
                                    class="nav-link {{ Request::routeIs('guestBook.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('guestBook.index') }}"
                                    class="nav-link {{ Request::routeIs('guestBook.index') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>All Guests</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('guestBook.history') }}"
                                    class="nav-link {{ Request::routeIs('guestBook.history') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Guest History</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
