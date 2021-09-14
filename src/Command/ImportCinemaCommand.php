<?php
// src/Command/ImportCinemaCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Entity\Cinema;
use App\Service\CinemaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class ImportCinemaCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:import-cinema';

    private EntityManagerInterface $manager;

	public function __construct(EntityManagerInterface $manager, CinemaService $cinemaService)
    {
        parent::__construct(self::$defaultName);
        $this->manager = $manager;
        $this->cinemaService = $cinemaService;
    }

    protected function configure(): void
    {
        $this
        ->setDescription('Imports a new sets of Cinemas from JSON.')

        ->setHelp('This command allows you to create a few cinemas from JSON')
    	;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
		$json = json_decode(file_get_contents('chemin du json'), true);

		foreach($json as $data) {
			$this->manager->persist($this->cinemaService->CreateCinema($data));
		}
        
        $this->manager->flush();
        
        $io->success('fichier importer avec succes');
        
        return Command::SUCCESS;
    }
}
