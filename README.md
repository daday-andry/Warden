# Warden user manager bundle

## Installation
*1- Ouvrir un terminal et deplacer dans le repertoire source de Warden (src)
*2- Lancer git clone https://github.com/daday-andry/Warden.git

### Pour ajouter Warden User manager dans le menu :
  ```
    - Ouvrir le fichier '#warden_root/src/Deeson/WardenBundle/Resources/views/layout.html.twig'
   
   ``` 
   - AJouter le code suivant anvant la fermeture du balise </ul> dans la ligne 147
        <li>
            <a href="{{ path('warden_user_manager_homepage') }}"><i class="fa fa-user"></i> &nbsp;<span>User Manager</span></a>
        </li>

