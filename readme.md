# GDMC - Gestion de la Direction de la Mairie de Carcassonne

Ce logiciel permet une gestion simple et efficace de certains modules utiles à la Mairie de Carcassonne :
- Elections : permet d'enregistrer le nombre d'inscriptions aux listes électorales et de recensement qui ont eu lieu par jours, de les afficher dans des tableaux (dont les mois de novembre et décembre peuvent être détaillés par jour, en raison d'un flux plus important dans cette période) et enfin de permettre une vue d'ensemble en version imprimable.

- Réunions : permet d'enregistrer des réunions, et de générer des comptes-rendu en complétant les participants, absents excusés, secrétaires, et sujets débattus. Il est également possible d'obtenir une version imprimable de ces comptes-rendu. Ce module pourrais servir à n'importe quelle administration.

- Actions : permet d'enregistrer des actions, qui ont été décidées en réunion ou comme bon vous semble, et d'en configurer des alertes. GDMC vous enverra ensuite une alerte (une alerte javascript) afin de vous rappeler que la date butoire approche. C'est entièrement configurable et vous pouvez activer ou désactiver les alertes pour une quelconque action.

# A propos de GDMC

GDMC a été construis à l'aide de PHPDesktop, avec Laravel 5.3 et Bootstrap 3.3.7. Il a été créé dans l'optique d'aider le travail des agents de la Mairie. Pour connaître plus de détail quant à comment maintenir le logiciel et comment partager la base de donnée dans un réseau, référez-vous à la partie ci-dessous.