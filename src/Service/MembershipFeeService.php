<?php
namespace App\Service;

use App\Entity\User;

class MembershipFeeService
{
    const MEMBER_SHIP_SERVICE_PROFESSION_CLASSES = [
        1 => 1.0,    // Vollbeschäftigt
        2 => 0.5,    // Schüler/Studenten
        3 => 0.25    // Arbeitssuchend/Rente
    ]; 

    const MEMBER_SHIP_SERVICE_AGE_CLASSES = [
        1 => 1.0,    // Minderjährig
        2 => 1.0,    // Volljährig
        3 => 1.25    // Boomer
    ]; 

    public function calculateFee(User $user): float
    {
        $fee = 10.00; // normaler satz von irgendwo holen/festlegen in Euro

        $birthday = $user->getBirthday();
        
        $professionFactor = self::MEMBER_SHIP_SERVICE_PROFESSION_CLASSES[$user->getProfession()];

        $now = new \DateTime();

        $dateDiff = $now->diff($birthday);
        $dateDiffYears = $dateDiff->y;

        switch ($dateDiffYears)
        {
            case ($dateDiffYears < 18):
                $ageFactor = 1;
                break;

            case ($dateDiffYears >= 18 && $dateDiffYears < 65):
                $ageFactor = 2;
                break;

            case ($dateDiffYears >= 65):
            default:
                $ageFactor = 3;
                break;
            
        }

        $fee = $fee * $professionFactor * self::MEMBER_SHIP_SERVICE_AGE_CLASSES[$ageFactor];

        return $fee;
    }
}