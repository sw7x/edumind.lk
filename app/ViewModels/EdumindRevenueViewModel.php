<?php 


class EdumindRevenueViewModel
{
    public $id;
    public $displayName;
    // Other properties...

    public function __construct(UserDTO $userDTO)
    {
        $this->id = $userDTO->id;
        $this->displayName = $this->formatDisplayName($userDTO->name);
        // Initialize other properties...
    }

    private function formatDisplayName($name)
    {
        // Perform any required formatting or transformation
        // For example, you can capitalize the name
        return ucwords($name);
    }
}