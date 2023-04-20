<?php
use App\Entity\Fruit;
use App\Repository\FruitRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FruitControllerTest extends WebTestCase
{
    private $entityManager;
    private $client;
    private $repository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->repository = $this->entityManager->getRepository(Fruit::class);
    }

    public function testFavorite()
    {
        $fruit = $this->repository->findOneBy([]);
        $id = $fruit->getId();

        $crawler = $this->client->request('POST', '/api/fruits/' . $id . '/favorite');

        $this->assertResponseIsSuccessful();
        $this->assertSame('{"success":true}', $this->client->getResponse()->getContent());

        $this->entityManager->refresh($fruit);
        $this->assertTrue($fruit->isFavorite());
    }

    public function testUnfavorite()
    {
        $fruit = $this->repository->findOneBy([]);
        $fruit->setFavorite(true);
        $this->entityManager->flush();
        $id = $fruit->getId();

        $crawler = $this->client->request('POST', '/api/fruits/' . $id . '/unfavorite');

        $this->assertResponseIsSuccessful();
        $this->assertSame('{"success":true}', $this->client->getResponse()->getContent());

        $this->entityManager->refresh($fruit);
        $this->assertFalse($fruit->isFavorite());
    }
}
