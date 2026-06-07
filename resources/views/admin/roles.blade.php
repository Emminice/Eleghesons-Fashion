<x-layouts.admin>
    <x-slot name="title">Role Management</x-slot>

    {{-- INFO BANNER --}}
    <div style="margin-bottom:20px">
        <div class="flash"
             style="background:#EFF6FF;border:1px solid #BFDBFE;color:#1D4ED8;
                    border-radius:10px;padding:14px 18px;display:flex;
                    align-items:flex-start;gap:12px">
            <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0"></i>
            <div style="font-size:13.5px;line-height:1.6">
                <strong>How role management works:</strong>
                Promoting a user to <strong>Admin</strong> gives them full access to this admin panel —
                products, orders, customers, coupons, and settings.
                Changing them back to <strong>Customer</strong> immediately revokes that access.
                You cannot change your own role or remove the last admin.
            </div>
        </div>
    </div>

    {{-- SEARCH & FILTER --}}
    <form method="GET" action="{{ route('admin.roles') }}"
          style="margin-bottom:20px;display:flex;gap:10px;flex-wrap:wrap">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by name or email…"
               style="flex:1;min-width:180px">
        <select name="role"
                style="padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;
                       font-family:inherit;font-size:14px;background:white;min-width:150px">
            <option value="">All Roles</option>
            <option value="admin"    @selected(request('role')==='admin')>Admins Only</option>
            <option value="customer" @selected(request('role')==='customer')>Customers Only</option>
        </select>
        <button type="submit" class="btn-secondary">Filter</button>
        @if(request('search') || request('role'))
            <a href="{{ route('admin.roles') }}" class="btn-secondary">Clear</a>
        @endif
    </form>

    {{-- TABLE --}}
    <div class="table-card">
        <div class="table-card-head">
            <h3>
                All Users
                <span style="font-size:13px;font-weight:400;color:var(--gray);margin-left:8px">
                    {{ $users->total() }} total
                </span>
            </h3>
            <div style="display:flex;gap:12px;font-size:13px;flex-wrap:wrap">
                <span style="display:flex;align-items:center;gap:6px">
                    <span style="width:10px;height:10px;background:#EF4444;border-radius:50%;display:inline-block"></span>
                    {{ \App\Models\User::where('role','admin')->count() }} Admin(s)
                </span>
                <span style="display:flex;align-items:center;gap:6px">
                    <span style="width:10px;height:10px;background:var(--orange);border-radius:50%;display:inline-block"></span>
                    {{ \App\Models\User::where('role','customer')->count() }} Customer(s)
                </span>
            </div>
        </div>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Current Role</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Change Role</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr style="{{ $user->id === auth()->id() ? 'background:#FFFBEB' : '' }}">
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;white-space:nowrap">
                                <div class="sidebar-avatar"
                                     style="width:36px;height:36px;font-size:13px;flex-shrink:0;
                                            background:{{ $user->role === 'admin' ? '#EF4444' : 'var(--orange)' }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->id === auth()->id())
                                        <span style="font-size:11px;color:var(--gray);margin-left:4px">(you)</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px;color:var(--gray);white-space:nowrap">{{ $user->email }}</td>
                        <td style="font-size:13px;color:var(--gray);white-space:nowrap">{{ $user->phone ?? '—' }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="status-badge" style="background:#FEF2F2;color:#EF4444;white-space:nowrap">
                                    <i class="fas fa-shield-alt"></i> Admin
                                </span>
                            @else
                                <span class="status-badge processing" style="white-space:nowrap">
                                    <i class="fas fa-user"></i> Customer
                                </span>
                            @endif
                        </td>
                        <td style="font-size:13px;color:var(--gray);white-space:nowrap">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <span class="status-badge {{ $user->is_active ? 'delivered' : 'cancelled' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            @if($user->id === auth()->id())
                                <span style="font-size:12px;color:var(--gray-light);font-style:italic;white-space:nowrap">
                                    Your account
                                </span>
                            @else
                                <form method="POST"
                                      action="{{ route('admin.roles.toggle', $user) }}"
                                      onsubmit="return confirm('{{ $user->role === 'admin'
                                            ? 'Demote '.$user->name.' to Customer?'
                                            : 'Promote '.$user->name.' to Admin? They will have full admin access.' }}')">
                                    @csrf @method('PATCH')
                                    @if($user->role === 'admin')
                                        <button type="submit" class="btn-secondary"
                                                style="padding:7px 14px;font-size:12px;white-space:nowrap;
                                                       border-color:#FECACA;color:#EF4444;background:#FEF2F2">
                                            <i class="fas fa-arrow-down"></i> Make Customer
                                        </button>
                                    @else
                                        <button type="submit" class="btn-secondary"
                                                style="padding:7px 14px;font-size:12px;white-space:nowrap;
                                                       border-color:#BFDBFE;color:#2563EB;background:#EFF6FF">
                                            <i class="fas fa-arrow-up"></i> Make Admin
                                        </button>
                                    @endif
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:48px;color:var(--gray)">
                            <i class="fas fa-users"
                               style="font-size:32px;display:block;margin-bottom:10px;color:var(--border)"></i>
                            No users found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding:16px 20px;border-top:1px solid var(--border)">
            {{ $users->links() }}
        </div>
    </div>

</x-layouts.admin>
