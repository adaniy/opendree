# GDMC - Gestion de la Direction de la Mairie de Carcassonne

Ce logiciel permet une gestion simple et efficace de certains modules utiles à la Mairie de Carcassonne :
- Elections : permet d'enregistrer le nombre d'inscriptions aux listes électorales et de recensement qui ont eu lieu par jours, de les afficher dans des tableaux (dont les mois de novembre et décembre peuvent être détaillés par jour, en raison d'un flux plus important dans cette période) et enfin de permettre une vue d'ensemble en version imprimable.

- Réunions : permet d'enregistrer des réunions, et de générer des comptes-rendu en complétant les participants, absents excusés, secrétaires, et sujets débattus. Il est également possible d'obtenir une version imprimable de ces comptes-rendu. Ce module pourrais servir à n'importe quelle administration.

- Actions : permet d'enregistrer des actions, qui ont été décidées en réunion ou comme bon vous semble, et d'en configurer des alertes. GDMC vous enverra ensuite une alerte (une alerte javascript) afin de vous rappeler que la date butoire approche. C'est entièrement configurable et vous pouvez activer ou désactiver les alertes pour une quelconque action.

# A propos de GDMC

GDMC a été construis à l'aide de PHPDesktop, avec Laravel 5.3 et Bootstrap 3.3.7. Il a été créé dans l'optique d'aider le travail des agents de la Mairie. Pour connaître plus de détail quant à comment maintenir le logiciel et comment partager la base de donnée dans un réseau, référez-vous à la partie ci-dessous.

# Guide d’utilisation en réseau

Afin de permettre l’utilisation en réseau de GDMC, il est important de suivre quelques consignes simple.

Tous d’abord, rendez-vous dans la racine du logiciel, soit quelque chose comme « C:\Programmes\GDMC ». Ca peut aussi être « C:\Program Files (x86)\GDMC » en cas d’utilisation sur une machine 64 bit.

Dans la racine, vous devriez avoir ça :

![Alt text](screenshots/lan-guide/1.png?raw=true "Optional Title")

Il vous faut maintenant modifier le fichier « settings.json » qui est sélectionné dans la capture d’écran. Afin de le modifier, vous pouvez double cliquer dessus, puis cocher « Sélectionner un programme dans la liste des programmes installés » et enfin, choisissez « Bloc note ».

A l’intérieur de ce fichier, allez dans la partie « www_directory », comme sur cette capture d’écran : 

![Alt text](screenshots/lan-guide/2.png?raw=true "Optional Title")

Le chemin par défaut étant « www/public », afin de le mettre sur un disque réseau, il vous faut donc rentrer son chemin entier, soit par exemple « S:/GDMC/www/public ».

Le nouveau chemin du moteur de GDMC étant défini, il vous faut maintenant copier des dossiers.

![Alt text](screenshots/lan-guide/3.png?raw=true "Optional Title")

Sélectionnez les dossiers « php » et « www », puis copiez-les. Enfin, rendez-vous dans le chemin que vous avez spécifiés, soit dans l’exemple, « S:/GDMC/ ». Une fois collé, vous remarquerez donc que le dossier www et le dossier public qui est à l’intérieur de ce dernier, correspondent bien au chemin que vous avez entré dans la configuration du logiciel, soit « S:/GDMC/www/public ».

![Alt text](screenshots/lan-guide/4.png?raw=true "Optional Title")

Maintenant, il faut vous assurer que la base de donnée est bien présente. Elle y sera par défaut, mais dans l’exemple où vous souhaiteriez utiliser la base de donnée de quelqu’un, il vous suffit de prendre le fichier « mairie.db » présent dans le dossier www de GDMC : 

![Alt text](screenshots/lan-guide/5.png?raw=true "Optional Title")

Si le fichier est bien présent ou que vous avez placé le votre, assurez vous qu’il soit toujours présent dans le dossier « www » et avec le nom « mairie.db », car un autre nom ne sera pas utilisé.

Si vous avez bien effectué ces recommandations, vous pourrez donc utiliser GDMC en réseau correctement et efficacement.
