<?php
namespace App\Permissions;
//use Illuminate\Auth\Access\Response;
//use Illuminate\Contracts\Support\Arrayable;
use App\Permissions\Settings\PermissionCheckResultEnum;
use Illuminate\Auth\Access\AuthorizationException;


class PermissionResponse
{
    protected string    $result;        /* Indicates result of the permission check. */
    protected bool      $allowed;       /* Indicates whether the response was allowed. */
    protected ?string   $message;       /* The response message. */
    protected ?int      $code;          /* The response code. */
    protected ?string   $redirectRoute; /* The redirect route name.*/

    public function __construct(
        string  $result,
        bool    $allowed,
        string  $message        = '',
        ?int    $code           = null,
        ?string $redirectRoute  = null
    ) {
        $this->result           = $result;
        $this->code             = $code;
        $this->allowed          = $allowed;
        $this->message          = $message;
        $this->redirectRoute    = $redirectRoute;
    }

    public static function allow(?string $message = null, $code = 200): self {
        return new static(
            PermissionCheckResultEnum::SUCCESS, 
            true, 
            $message, 
            $code
        );
    }

    public static function deny(
        string  $result         = PermissionCheckResultEnum::FORBIDDEN,
        ?string $message        = null, 
        ?int    $code           = 403, 
        ?string $redirectRoute  = null
    ): self {
        return new static(
            $result,
            false, 
            $message, 
            $code, 
            $redirectRoute
        );
    }
    
    /* Get the result of the permission check. */
    public function result(): string {
        return $this->result;
    }

    /* Determine if the response was allowed. */
    public function allowed(): bool {
        return $this->allowed;
    }

    /* Determine if the response was denied. */
    public function denied(): bool {
        return !$this->allowed();
    }

    public function message(): ?string {
        return $this->message;
    }

    public function code(): ?int {
        return $this->code;
    }

    public function redirectRoute(): ?string {
        return $this->redirectRoute;
    }

    public function authorize(): self {
        if ($this->denied()) {
            throw (
                new AuthorizationException($this->message(), $this->code())
            )->setResponse($this);
        }

        return $this;
    }

    public function toArray(): array {
        return [
            'result'        => $this->result(),
            'allowed'       => $this->allowed(),
            'message'       => $this->message(),
            'code'          => $this->code(),
            'redirectRoute' => $this->redirectRoute(),
        ];
    }

    /* Get the string representation of the message. */
    public function __toString(): string {
        return (string)$this->message();
    }
}