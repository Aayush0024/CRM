<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\Note;
use App\Models\Task;
use App\Policies\ContactPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\DealPolicy;
use App\Policies\LeadPolicy;
use App\Policies\NotePolicy;
use App\Policies\ReportPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Note::class     => NotePolicy::class,
        Lead::class     => LeadPolicy::class,
        Deal::class     => DealPolicy::class,
        Task::class     => TaskPolicy::class,
        Customer::class => CustomerPolicy::class,
        Contact::class  => ContactPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // ── Admin-only gates ──────────────────────────────────────────────
        Gate::define('manage-users', fn ($user) => $user->isAdmin());
        Gate::define('manage-settings', fn ($user) => $user->isAdmin());
        Gate::define('disable-accounts', fn ($user) => $user->isAdmin());
        Gate::define('reset-passwords', fn ($user) => $user->isAdmin());

        // ── Admin + Manager gates ─────────────────────────────────────────
        Gate::define('view-reports', fn ($user) => $user->canViewReports());
        Gate::define('view-team-reports', fn ($user) => $user->isAdmin() || $user->isManager());
        Gate::define('assign-deals', fn ($user) => $user->isAdmin() || $user->isManager());
        Gate::define('manage-team-leads', fn ($user) => $user->isAdmin() || $user->isManager());

        // ── Report model gate (used via can('viewAny', ReportPolicy)) ─────
        Gate::policy(\stdClass::class, ReportPolicy::class);

        // ── Convenience gate for reports (used in controllers/views) ──────
        Gate::define('access-reports', fn ($user) => $user->canViewReports());
    }
}
