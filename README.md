BIWikiCfgPageParser
===================

Script PHP permettant d'extraire les informations de certaines pages du [wiki](https://community.bistudio.com/wiki/) de Bohemia Interactive pour ArmA 3

Les pages suivantes sont analysées :

  * [Arma_3_CfgWeapons_Weapons](https://community.bistudio.com/wiki/Arma_3_CfgWeapons_Weapons) - Armes
  * [Arma_3_CfgMagazines](https://community.bistudio.com/wiki/Arma_3_CfgMagazines) - Chargeurs
  * [Arma_3_CfgWeapons_Items](https://community.bistudio.com/wiki/Arma_3_CfgWeapons_Items) - Accessoires des armes
  * [Arma_3_CfgWeapons_Equipment](https://community.bistudio.com/wiki/Arma_3_CfgWeapons_Equipment) - Equipements

Les résultats de l'analyse sont enregistrés dans le dossier `exports`, dans un fichier PHP contenant un tableau. Si des images ont été téléchargées, elles sont enregistrées dans un sous-dossier du même nom que la page.

## Utilisation (PHP 5.3+)

```
php run.php
```