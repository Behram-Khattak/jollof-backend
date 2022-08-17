<?php

namespace App\Models;

/**
 * App\Models\Audit.
 *
 * @property int                                           $id
 * @property null|string                                   $user_type
 * @property null|int                                      $user_id
 * @property string                                        $event
 * @property string                                        $auditable_type
 * @property int                                           $auditable_id
 * @property null|array                                    $old_values
 * @property null|array                                    $new_values
 * @property null|string                                   $url
 * @property null|string                                   $ip_address
 * @property null|string                                   $user_agent
 * @property null|string                                   $tags
 * @property null|\Illuminate\Support\Carbon               $created_at
 * @property null|\Illuminate\Support\Carbon               $updated_at
 * @property \Eloquent|\Illuminate\Database\Eloquent\Model $auditable
 * @property \Eloquent|\Illuminate\Database\Eloquent\Model $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Audit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereAuditableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereAuditableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereNewValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereOldValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereUserType($value)
 * @mixin \Eloquent
 */
class Audit extends \OwenIt\Auditing\Models\Audit
{
}
