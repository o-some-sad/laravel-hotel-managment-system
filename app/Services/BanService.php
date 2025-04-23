<?php

namespace App\Services;

use Cog\Contracts\Ban\Ban as BanContract;
use Cog\Laravel\Ban\Services\BanService as BaseBanService;
use App\Models\User;

class BanService extends BaseBanService
{
    /**
     * Ban the user
     * 
     * @param User $user
     * @return \Cog\Laravel\Ban\Models\Ban
     */
    public function banUser(User $user): BanContract
    {
        
          return $this->ban($user);
    }

    /**
     * Unban the user
     * 
     * @param User $user
     * @return bool
     */
    public function unbanUser(User $user): bool
    {
          return (bool) $this->unban($user);
    }
}


