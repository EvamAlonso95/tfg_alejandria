<?php

class Role
{
	private int $id;
	private string $name;

	public function __construct() {}
	public static function createById(int $id): self
	{
		$instance = new self();

		$stmt = Database::getInstance()->prepare("SELECT * FROM roles WHERE id = :id");
		$stmt->execute([':id' => $id]);

		$role = $stmt->fetch(PDO::FETCH_OBJ);

		if (!$role) {
			throw new RuntimeException("Rol con ID $id no encontrado");
		}
		$instance->id = $role->id;
		$instance->name = $role->name;

		return $instance;
	}

	public static function createByName(string $name): self
	{

		$instance = new self();

		$stmt = Database::getInstance()->prepare("SELECT * FROM roles WHERE name = :name");
		$stmt->execute([':name' => $name]);

		$role = $stmt->fetch(PDO::FETCH_OBJ);

		if (!$role) {
			throw new RuntimeException("Role con nombre $name no encontrado");
		}

		$instance->id = $role->id;
		$instance->name = $role->name;

		return $instance;
	}

	public function getId(): ?int
	{
		return Utils::escapeData($this->id);
	}

	public function getName(): string
	{
		return Utils::escapeData($this->name);
	}

	// Método para obtener todos los roles
	public function getRoles(): array
	{
		$sql = "SELECT * FROM roles";
		$stmt = Database::getInstance()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
