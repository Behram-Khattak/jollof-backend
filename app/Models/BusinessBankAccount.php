<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BusinessBankAccount.
 *
 * @property int                             $id
 * @property int                             $bank_id
 * @property int                             $business_id
 * @property string                          $account_name
 * @property string                          $account_number
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property \App\Models\Bank                $bank
 * @property \App\Models\Business            $business
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBankAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBankAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBankAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBankAccount whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBankAccount whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBankAccount whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBankAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessBankAccount extends Model
{
    protected $guarded = ['id'];

    /**
     * A business bank account belongs to a bank.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    /**
     * A business bank account belongs to a business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}
