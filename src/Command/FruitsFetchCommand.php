<?php

namespace App\Command;

use App\Entity\Fruit;
use App\Mailer\FruitsSavedEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FruitsFetchCommand extends Command
{
    protected static $defaultName = 'fruits:fetch';
    
    private $httpClient;
    private $entityManager;
    private $mailer;
    
    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager, FruitsSavedEmail $mailer)
    {
        parent::__construct();
        
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }
    
    protected function configure()
    {
        $this->setDescription('Fetches all fruits from the API and saves them to the database.');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->httpClient->request('GET', 'https://fruityvice.com/api/fruit/all');

        if ($response->getStatusCode() !== 200) {
            $output->writeln('Failed to fetch fruits');
            return Command::FAILURE;
        }

        $data = $response->toArray();
        
        foreach ($data as $fruitData) {
            $fruit = new Fruit();
            $fruit->setName($fruitData['name']);
            $fruit->setFamily($fruitData['family']);
            $fruit->setGenus($fruitData['genus']);
            $fruit->setOrder($fruitData['order'] ?? 0);
            $fruit->setCarbohydrates($fruitData['nutritions']['carbohydrates'] ?? 0);
            $fruit->setProtein($fruitData['nutritions']['protein'] ?? 0);
            $fruit->setFat($fruitData['nutritions']['fat'] ?? 0);
            $fruit->setSugar($fruitData['nutritions']['sugar'] ?? 0);
            $fruit->setCalories($fruitData['nutritions']['calories'] ?? 0);
            
            $this->entityManager->persist($fruit);
        }

        $this->entityManager->flush();
        
        $this->mailer->send();

        $output->writeln('Fruits fetched and saved to the database.');
        
        return Command::SUCCESS;
    }
}
