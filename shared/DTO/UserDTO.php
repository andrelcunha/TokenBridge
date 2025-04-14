<?php
namespace Shared\DTO;

class UserDTO
{
    public $id;
    public $name;
    public $email;

    public function __construct($id, $name, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    // Serialize the DTO into a JSON string
    public function toJson()
    {
        return json_encode([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }

    // Deserialize JSON into a UserDTO instance
    public static function fromJson($json)
    {
        $data = json_decode($json, true);
        return new self($data['id'], $data['name'], $data['email']);
    }
}
