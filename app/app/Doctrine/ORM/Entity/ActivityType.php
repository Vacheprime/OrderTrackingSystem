<?php

namespace app\Doctrine\ORM\Entity;

/**
 * Enum Activity
 * 
 * Represents the action performed on an order,
 * such as viewing or editing
 */
enum ActivityType: string {
    case VIEWED = "VIEWED";
    case EDITED = "EDITED";
}