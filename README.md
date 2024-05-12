Leaf CMF is Content Management Framework based on Symfony Framework.  

# Installation
Copy `compose.override-example.yaml` and create `compose.override.yaml` with custom configuration if needed.  
Run `make dev`  
Open http://localhost

# Description / Overview
The CMF system, unlike the CMS system, uses abstraction to 
manage elements. Thanks to this, you can create any structure 
with any name with just a few clicks in the configuration:

![CMS vs CMF.jpeg](doc%2FCMS%20vs%20CMF.jpeg)

# TODO
- move docker files to docker dir
- catch configuration not found in controller or add it to validation (which is not used now)
- update readme with tests, running dev env
- make xdebug running on local env (and phpunit coverage)