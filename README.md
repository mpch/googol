googol
======

Une page php pour utiliser google en utilisant des liens safe: Googol parse la page de résultats et régénère une page en proposant des liens directs. (jetez également un oeil au référer ^^ )

Testez à http://googol.warriordudimanche.net/

Ajouts de la 1.6:
- ajout de deux !bangs reprenant le principe de DDG: 
    - !ddg pour rechercher sur Duckduckgo
    - !gi pour rechercher sur google images (attention, on n'est plus anonyme)
- ajout de la possibilité d'utiliser orange proxy (https://github.com/broncowdd/OrangeProxy ) 
   si on précise l'URL de son serveur proxy dans la constante ORANGE_PROXY_URL, googol va ajouter des liens proxy aux résultats et va utiliser le proxy avec les bangs.



;)

A php script to search on google with safe linhs and thumbs... It parses the google page's results and makes a brand new one: google only knows the server's ip adress ! ^^

added in 1.6:
- added two DDG's like !bangs : 
    - !ddg to search on Duckduckgo
    - !gi to search on google images (no more safe links)
- added the use of orange proxy (https://github.com/broncowdd/OrangeProxy ) 
   if you set the ORANGE_PROXY_URL constant, googol will add proxy links to the results and use the proxy with the bangs.
