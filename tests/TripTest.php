<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Database;
use App\Models\Trip;

/**
 * @covers \App\Models\Trip
 */
final class TripTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->pdo->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->pdo->rollBack();
    }

    public function testCreateUpdateDeleteTrip(): void
    {
        $data = [
            'agency_from_id' => 1,
            'agency_to_id' => 2,
            'departure_datetime' => date('Y-m-d H:i:s', strtotime('+1 day')),
            'arrival_datetime' => date('Y-m-d H:i:s', strtotime('+1 day +3 hours')),
            'seats_total' => 4,
            'seats_available' => 4,
            'contact_user_id' => 1,
            'created_by_user_id' => 1,
        ];

        $id = Trip::create($data);
        $this->assertIsInt($id);

        $data['seats_available'] = 3;
        Trip::update($id, $data);

        $stmt = $this->pdo->prepare('SELECT seats_available FROM trips WHERE id = ?');
        $stmt->execute([$id]);
        $val = $stmt->fetchColumn();
        $this->assertEquals(3, (int)$val);

        $res = Trip::deleteById($id);
        $this->assertTrue($res);
    }
}