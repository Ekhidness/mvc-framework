<?php
namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;
    protected $table = 'Users';
    protected $primaryKey = 'UserID';
    public $timestamps = false;
    protected $fillable = ['Login', 'PasswordHash', 'RoleID', 'IsBlocked', 'api_token', 'token_expires_at'];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->PasswordHash = md5($user->PasswordHash);
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'RoleID', 'RoleID');
    }

    public function findIdentity(int $id)
    {
        return self::where('UserID', $id)->where('IsBlocked', 0)->first();
    }

    public function getId(): int
    {
        return $this->UserID;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where([
            'Login' => $credentials['login'],
            'PasswordHash' => md5($credentials['password']),
            'IsBlocked' => 0
        ])->first();
    }

    public function isAdmin(): bool
    {
        return $this->role && $this->role->RoleName === 'admin';
    }

    public function isSysAdmin(): bool
    {
        return $this->role && $this->role->RoleName === 'sysadmin';
    }

    public function canAccessSystem(): bool
    {
        return $this->isAdmin() || $this->isSysAdmin();
    }

    public function generateApiToken(): string
    {
        $token = bin2hex(random_bytes(32));
        $this->api_token = $token;
        $this->token_expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));
        $this->save();
        return $token;
    }

    public function isValidApiToken(string $token): bool
    {
        if ($this->api_token !== $token) {
            return false;
        }
        if ($this->token_expires_at && strtotime($this->token_expires_at) < time()) {
            return false;
        }
        return true;
    }
}