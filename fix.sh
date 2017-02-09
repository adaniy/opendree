git filter-branch --commit-filter '
        if [ "$GIT_AUTHOR_EMAIL" = "ifthenelse42@gmail.com" ];
        then
		GIT_COMMITTER_NAME="Daniel Medina";
                GIT_AUTHOR_NAME="Daniel Medina";
		GIT_COMMITTER_EMAIL="daniel.medina11@protonmail.com";
                GIT_AUTHOR_EMAIL="daniel.medina11@protonmail.com";
                git commit-tree "$@";
        else
                git commit-tree "$@";
        fi' HEAD
