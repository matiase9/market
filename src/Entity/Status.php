<?php

namespace App\Entity;

class Status {

    const PEDING = 'Pending Confirmation';
    const CONFIRMED = 'Confirmed';
    const TO_WAREHOUSE = 'Sent to Warehouse';
    const SHIPPED = 'Shipped';
    const IN_TRANSIT = 'In Transit';
    const DELIVERED = 'Delivered';

    const CODE_PEDING = 'pending';
    const CODE_CONFIRMED = 'confirmed';
    const CODE_TO_WAREHOUSE = 'sent_warehouse';
    const CODE_SHIPPED = 'shipped';
    const CODE_IN_TRANSIT = 'in_transit';
    const CODE_DELIVERED = 'delivered';

    public function getStatus($status)
    {
        switch ($status) {
            case self::CODE_PEDING:
                return self::CODE_PEDING;
                break;
            case self::CODE_CONFIRMED:
                return self::CODE_CONFIRMED;
                break;
            case self::CODE_TO_WAREHOUSE:
                return self::CODE_TO_WAREHOUSE;
                break;
            case self::CODE_SHIPPED:
                return self::CODE_SHIPPED;
                break;
            case self::CODE_IN_TRANSIT:
                return self::CODE_IN_TRANSIT;
                break;
            case self::CODE_DELIVERED:
                return self::CODE_DELIVERED;
                break;
        }
        return null;
    }

    public function getStatusInitial()
    {
        return self::PEDING;
    }

    public function getStatusLabel($statusCode)
    {
        switch ($statusCode) {
            case self::CODE_PEDING:
                return self::PEDING;
                break;
            case self::CODE_CONFIRMED:
                return self::CONFIRMED;
                break;
            case self::CODE_TO_WAREHOUSE:
                return self::TO_WAREHOUSE;
                break;
            case self::CODE_SHIPPED:
                return self::SHIPPED;
                break;
            case self::CODE_IN_TRANSIT:
                return self::IN_TRANSIT;
                break;
            case self::CODE_DELIVERED:
                return self::DELIVERED;
                break;
        }
        return null;
    }
}