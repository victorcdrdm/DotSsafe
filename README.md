# DotSsafe
Teste technique Dotsafe
pour lancer le projet en Local

1# etape copier coller le fichier .env et le renomer .env.local
commander la ligne 27 et decomter la ligne 26 remplacer les information de connection a votre base de donées.

#2
ouvrer un terminal et placer vous la racine du projet backend

executer la serie de commande suivant :

php bin/console doctrine:database:create
php bin/console d:m:m
symfony sever start

symfony devrait lancer un serveur a l'adresse suivante http://127.0.0.1:8000/'.

si ce n'est pas le cas copier l'url qui s'affichent sur votre ecran et remplacer 
dans le fichier vue/utils/http.js remplacer l'url qui se trouve entre le guillemet de la ligne 5.

rendez vous a la racine du dossier vue
puis tapper les commande suivante:

npm install

npm run serve


