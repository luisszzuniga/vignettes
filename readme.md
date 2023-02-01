Pour faire les migrations:
"php bin/console doctrine:migrations:migrate"

Pour ajouter l'user Admin :
"php bin/console doctrine:fixtures:load"

email: admin@admin.com
password: password

Pour changer les grid_size il faut aller direct en base

ATTENTION: ça efface toute la base de données