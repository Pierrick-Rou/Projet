télécharger WampServeur



Créer un projet symfony :
  cd puis la localisation
  
  créer le dossier :
    symfony new NouveauPojet --version=lts --webapp
  lancer le serveur :
    symfony serve
    
  Creer un controller :
    symfony console make::controller NewController
    
  créer le dossier entity (pour les classes):
     symfony console make:entity   

  créer la base de données :
    symfony console doctrine:database:create
    symfony console make:migration => créer les tables 
    symfony console doctrine:migration:migrate => exectute les tables en attente

    ensuite sur la database sur la droite + -> data source ->my SQL

  pour générer un jeu de données fictives :
    symfony composer require --dev orm-fixtures
    symfony console make:fixtures
    symfony composer req fakerphp/faker  --dev
    symfony console doctrine:fixtures:load
     
  Créer un form à travers symfony :
     symfony console make:form   

  Utiliser la sécurity avce symphony :
  symfony server:ca:install
  symfony console make:user
  symfony console make:mi
  symfony console make:do:mi:mi
  symfony console make:security:form-login  

  pour hasher un password manuellement  :  symfony console security:hash-password     


//installer Composer
   symfony composer install
   
