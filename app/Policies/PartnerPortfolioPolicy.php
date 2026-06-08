<?php

namespace App\Policies;

use App\Models\PartnerPortfolio;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PartnerPortfolioPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PartnerPortfolio $partnerPortfolio): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'mitra';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PartnerPortfolio $partnerPortfolio): bool
    {
        return $user->id === $partnerPortfolio->partner_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PartnerPortfolio $partnerPortfolio): bool
    {
        return $user->id === $partnerPortfolio->partner_id || $user->role === 'admin';
    }
}
