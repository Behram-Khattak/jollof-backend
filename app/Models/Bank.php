<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bank.
 *
 * @property int                                                                        $id
 * @property string                                                                     $name
 * @property string                                                                     $code
 * @property null|\Illuminate\Support\Carbon                                            $created_at
 * @property null|\Illuminate\Support\Carbon                                            $updated_at
 * @property \App\Models\BusinessBankAccount[]|\Illuminate\Database\Eloquent\Collection $account
 * @property null|int                                                                   $account_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bank extends Model
{
    protected $guarded = ['id'];

    /**
     * A bank has many business bank accounts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function account()
    {
        return $this->hasMany(BusinessBankAccount::class, 'bank_id');
    }
}
