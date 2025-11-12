<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

/**
 * Trip model (CRUD).
 *
 * @psalm-type TripRow = array{
 *   id:int,
 *   agency_from_id:int,
 *   agency_to_id:int,
 *   departure_datetime:string,
 *   arrival_datetime:string,
 *   seats_total:int,
 *   seats_available:int,
 *   contact_user_id:int,
 *   created_by_user_id:int,
 *   agency_from?:string|null,
 *   agency_to?:string|null,
 *   from_name?:string|null,
 *   to_name?:string|null
 * }
 */
class Trip
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function getAllAvailable(): array
    {
        $db = Database::getConnection();

        $sql = "
            SELECT 
                t.id,
                a1.name AS from_name,
                a2.name AS to_name,
                t.departure_datetime,
                t.arrival_datetime,
                t.seats_total,
                t.seats_available,
                t.contact_user_id,
                t.created_by_user_id,
                u.nom,
                u.prenom,
                u.email,
                u.phone
            FROM trips t
            JOIN agencies a1 ON a1.id = t.agency_from_id
            JOIN agencies a2 ON a2.id = t.agency_to_id
            JOIN users u ON u.id = t.contact_user_id
            WHERE t.seats_available > 0
            ORDER BY t.departure_datetime ASC
        ";

        $stmt = $db->query($sql);

        if ($stmt === false) {
            // 🔒 Sécurité : en cas d’erreur SQL, retourne un tableau vide
        return [];
    }

    /** @var array<int, array<string, mixed>> $results */
    $results = $stmt->fetchAll();

    return $results;
    }

    /**
     * @param int $userId
     * @return array<int, array<string, mixed>>
     */
    public static function findByUser(int $userId): array
    {
        $db = Database::getConnection();
        $sql = "
            SELECT 
                t.id,
                a1.name AS from_name,
                a2.name AS to_name,
                t.departure_datetime,
                t.arrival_datetime,
                t.seats_total,
                t.seats_available,
                t.contact_user_id,
                t.created_by_user_id,
                u.nom,
                u.prenom,
                u.email,
                u.phone
            FROM trips t
            JOIN agencies a1 ON a1.id = t.agency_from_id
            JOIN agencies a2 ON a2.id = t.agency_to_id
            JOIN users u ON u.id = t.contact_user_id
            WHERE t.created_by_user_id = :userId
            ORDER BY t.departure_datetime ASC
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Delete by id.
     */
    public static function deleteById(int $id): bool
    {
        $db = Database::getConnection();
        
        $stmt = $db->prepare('DELETE FROM trips WHERE id = ?');
        $res = $stmt->execute([$id]);
        
        return $res;
    }

    /**
     * Create a trip.
     *
     * @param array{
     *   agency_from_id:int,
     *   agency_to_id:int,
     *   departure_datetime:string,
     *   arrival_datetime:string,
     *   seats_total:int,
     *   seats_available:int,
     *   contact_user_id:int,
     *   created_by_user_id:int
     * } $data
     * @return int
     */
    public static function create(array $data): int
    {
        $db = Database::getConnection();
        

        $stmt = $db->prepare('
            INSERT INTO trips
            (agency_from_id, agency_to_id, departure_datetime, arrival_datetime, seats_total, seats_available, contact_user_id, created_by_user_id)
            VALUES (:from, :to, :dep, :arr, :total, :avail, :contact, :creator)
        ');
        $stmt->execute([
            'from'    => $data['agency_from_id'],
            'to'      => $data['agency_to_id'],
            'dep'     => $data['departure_datetime'],
            'arr'     => $data['arrival_datetime'],
            'total'   => $data['seats_total'],
            'avail'   => $data['seats_available'],
            'contact' => $data['contact_user_id'],
            'creator' => $data['created_by_user_id'],
        ]);
        $id = (int) $db->lastInsertId();
        assert($id > 0);
        return $id;
    }

    /**
     * Update a trip.
     *
     * @param int $id
     * @param array<string, mixed> $data
     * @return void
     */
    public static function update(int $id, array $data): void
    {
        $db = Database::getConnection();
        

        $stmt = $db->prepare("
            UPDATE trips
            SET agency_from_id = :agency_from_id,
                agency_to_id = :agency_to_id,
                departure_datetime = :departure_datetime,
                arrival_datetime = :arrival_datetime,
                seats_total = :seats_total,
                seats_available = :seats_available,
                contact_user_id = :contact_user_id,
                created_by_user_id = :created_by_user_id
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $id,
            'agency_from_id' => (int)$data['agency_from_id'],
            'agency_to_id' => (int)$data['agency_to_id'],
            'departure_datetime' => (string)$data['departure_datetime'],
            'arrival_datetime' => (string)$data['arrival_datetime'],
            'seats_total' => (int)$data['seats_total'],
            'seats_available' => (int)$data['seats_available'],
            'contact_user_id' => (int)$data['contact_user_id'],
            'created_by_user_id' => (int)$data['created_by_user_id'],
        ]);
    }
}