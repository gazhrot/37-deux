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
        // the short description shown while running "php bin/console list"
        ->setDescription('Creates a new user.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create a user...')
    	;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
		$json = json_decode(file_get_contents('C:\Users\Gazh\Desktop\224400028_salles-de-cinema-en-loire-atlantique.json'), true);

		foreach($json as $data) {
			$this->manager->persist($this->cinemaService->CreateCinema($data));
		}
        
        $this->manager->flush();
        
        $io->success('fichier importer avec succes');
        
        return Command::SUCCESS;
    }
}
