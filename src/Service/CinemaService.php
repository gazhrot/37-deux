<?php
// src/Service/CinemaService.php
namespace App\Service;

use App\Entity\Cinema;

class CinemaService
{
    public function CreateCinema($data): Cinema
    {
        $courriel ='';
        $site_web = '';

        if (isset($data['fields']['courriel'])) { $courriel = $data['fields']['courriel']; }
        if (isset($data['fields']['site_web'])) { $site_web = $data['fields']['site_web']; }

        $cinema = (new Cinema())
                     ->setVille($data['fields']['ville'])
                     ->setAdresse($data['fields']['adresse'])
                     ->setTelephone($data['fields']['telephone'])
                     ->setCodeSalles($data['fields']['code_salles'])
                     ->setOrganisme($data['fields']['organisme'])
                     ->setSiteWeb($site_web)
                     ->setCourriel($courriel)
                     ->setCp($data['fields']['cp']);

        return $cinema;
    }
}
