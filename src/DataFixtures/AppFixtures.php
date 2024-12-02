<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Dette;
use App\Entity\Client;
use App\Entity\Detail;
use App\Entity\Article;
use App\Entity\Paiement;
use App\Entity\DemandeDette;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $encoder
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Réduire le nombre de données générées
        $this->loadArticles($manager);
        $this->loadClients($manager);
        $this->loadDetails($manager);
        $this->loadBase($manager);

        $manager->flush();
    }

    private function loadBase(ObjectManager $manager): void 
    {
        $admin = new User();
        $client = new User();
        $boutiquier = new User();
        $admin->setLogin('a')
            ->setPassword($this->encoder->hashPassword($admin, 'a'))
            ->setRoles(["ROLE_ADMIN"])
            ->setEmail('admin@example.com');
        $client->setLogin('c')
            ->setPassword($this->encoder->hashPassword($client, 'c'))
            ->setRoles(["ROLE_CLIENT"])
            ->setEmail('client@example.com');
        $boutiquier->setLogin('b')
            ->setPassword($this->encoder->hashPassword($boutiquier, 'b'))
            ->setRoles(["ROLE_BOUTIQUIER"])
            ->setEmail('boutiquier@example.com');
        $manager->persist($admin);
        $manager->persist($client);
        $manager->persist($boutiquier);
    }

    private function loadArticles(ObjectManager $manager): void
    {
        // Générer moins d'articles
        for ($i = 1; $i <= 50; $i++) {
            $article = new Article();
            $article->setLibelle('Article ' . $i);
            $article->setPrix($i * 500);
            $article->setQteStock(100 + $i);
            $manager->persist($article);
        }
    }

    private function loadClients(ObjectManager $manager): void
    {
        // Réduire le nombre de clients et de données associées
        for ($i = 1; $i <= 50; $i++) {
            $client = new Client();
            $client->setSurname('Client ' . $i. ' - Société');
            $client->setTel('7712312' . $i . '-' . rand(0, 9999));
            $client->setAddress('Société St '. $i);

            if ($i % 2 == 0) {
                $user = $this->createUser($client, $i, $manager);
                $this->createDettes($client, $i, $manager);
            }

            $manager->persist($client);
        }
    }

    private function createUser(Client $client, int $i, ObjectManager $manager): User
    {
        $user = new User();
        $user->setEmail('user' . $i . '@example.com');
        $user->setRoles(['ROLE_CLIENT']);
        $user->setLogin('user' . $i);
        $plaintextPassword = 'password' . $i;
        $hashedPassword = $this->encoder->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);
        $user->setClient($client);
        $manager->persist($user);
        return $user;
    }

    private function createDettes(Client $client, int $i, ObjectManager $manager): void
    {
        // Limiter le nombre de dettes par client
        $dette = new Dette();
        $dette->setMontantTotal($i * 10000);
        $dette->setMontantVerser($i * 5000);
        $dette->setClient($client);

        $pay = new Paiement();
        $pay->setMontantPaye($i * 5000);
        $dette->addPaiement($pay);
        $manager->persist($pay);
        $manager->persist($dette);

        $demandeDette = new DemandeDette();
        $demandeDette->setCreatedAt(new \DateTimeImmutable());
        $demandeDette->setMontantTotal($i * 500);
        $demandeDette->setClient($client);
        $dette->setDemandeDette($demandeDette);
        $manager->persist($demandeDette);
    }

    private function loadDetails(ObjectManager $manager): void
    {
        // Créer des détails de manière plus contrôlée
        $articles = $manager->getRepository(Article::class)->findAll();
        $dettes = $manager->getRepository(Dette::class)->findAll();

        if (!empty($articles) && !empty($dettes)) {
            $detail = new Detail();
            $detail->setPrixVente(10);
            $detail->setArticle($articles[0]);
            $detail->setQte(10);
            $detail->setDette($dettes[0]);
            $manager->persist($detail);
        }
    }
}