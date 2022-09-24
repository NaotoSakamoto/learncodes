<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Learncode;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin'
    ]; 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function learncodes()
    {
        return $this->hasMany(Learncode::class);
    }
    
    public function loadRelationshipCounts()
    {
        $this->loadCount(['learncodes', 'followings', 'followers', 'favorites']);
    }
    
    /**
     * このユーザがフォロー中のユーザ。（ Userモデルとの関係を定義）
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    /**
     * このユーザをフォロー中のユーザ。（ Userモデルとの関係を定義）
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }

    public function follow($userId)
    {
        // すでにフォローしているか
        $exist = $this->is_following($userId);
        // 対象が自分自身かどうか
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
            // フォロー済み、または、自分自身の場合は何もしない
            return false;
        } else {
            // 上記以外はフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }

    /**
     * $userIdで指定されたユーザをアンフォローする。
     *
     * @param  int  $userId
     * @return bool
     */
    public function unfollow($userId)
    {
        // すでにフォローしているか
        $exist = $this->is_following($userId);
        // 対象が自分自身かどうか
        $its_me = $this->id == $userId;

        if ($exist && !$its_me) {
            // フォロー済み、かつ、自分自身でない場合はフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 上記以外の場合は何もしない
            return false;
        }
    }

    /**
     * 指定された $userIdのユーザをこのユーザがフォロー中であるか調べる。フォロー中ならtrueを返す。
     *
     * @param  int  $userId
     * @return bool
     */
    public function is_following($userId)
    {
        // フォロー中ユーザの中に $userIdのものが存在するか
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    /**
     * このユーザとフォロー中ユーザの投稿に絞り込む。
     */
    public function feed_learncodes()
    {
        // このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        // このユーザのidもその配列に追加
        $userIds[] = $this->id;
        // それらのユーザが所有する投稿に絞り込む
        return Learncode::whereIn('user_id', $userIds);
    }
    
    // 指定された $learncodeIdの投稿をこのユーザがお気に入り中であるか調べる
    public function is_favoriting($learncodeId)
    {
        return $this->favorites()->where('learncode_id', $learncodeId)->exists();
    }

    // このユーザが登録したお気に入りの一覧を取得する
    public function favorites()
    {
        return $this->belongsToMany(Learncode::class, 'favorites', 'user_id', 'learncode_id')->withTimestamps();
    }

    // お気に入りする
    public function favorite($learncodeId)
    {
        // すでにお気に入りしているか
        $exist = $this->is_favoriting($learncodeId);

        if ($exist) {
            // お気に入りの済み場合は何もしない
            return false;
        } else {
            // 上記以外はお気に入りする
            $this->favorites()->attach($learncodeId);
            return true;
        }
    }

    // お気に入りを解除する
    public function unfavorite($learncodeId)
    {
        // すでにお気に入りしているか
        $exist = $this->is_favoriting($learncodeId);

        if ($exist) {
            // お気に入り済みの場合は外す
            $this->favorites()->detach($learncodeId);
            return true;
        } else {
            // 上記以外の場合は何もしない
            return false;
        }  
    }
}
