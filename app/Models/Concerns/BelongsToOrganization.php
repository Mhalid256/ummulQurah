<?php

namespace App\Models\Concerns;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;

/**
 * Adds automatic multi-organization data isolation.
 * Every query is scoped to the logged-in user's organization,
 * unless the user is a Super Administrator (who can see all orgs,
 * or filter via ?organization_id= in controllers).
 */
trait BelongsToOrganization
{
    public static function bootBelongsToOrganization(): void
    {
        static::addGlobalScope('organization', function (Builder $builder) {
            if (auth()->check() && ! auth()->user()->isSuperAdmin()) {
                $builder->where($builder->getModel()->getTable() . '.organization_id', auth()->user()->organization_id);
            } elseif (auth()->check() && auth()->user()->isSuperAdmin() && session('acting_organization_id')) {
                // A Super Admin who has picked an "acting organization" from the
                // switcher sees that organization's data only, same as a normal user.
                $builder->where($builder->getModel()->getTable() . '.organization_id', session('acting_organization_id'));
            }
        });

        static::creating(function ($model) {
            if (empty($model->organization_id) && auth()->check()) {
                // Normal users belong to one organization. Super Admins have none
                // of their own, so we fall back to whichever organization they've
                // selected in the switcher (see OrganizationSwitchController).
                $model->organization_id = auth()->user()->organization_id ?? session('acting_organization_id');
            }
        });
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}