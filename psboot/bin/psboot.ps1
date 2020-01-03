# When the container starts up

# It needs to know whether to use a local file, or reach out to a PSBoot Server

# If it's a local file, read in the json, Get the list of Modules to install
# Else Get the SystemName and get the list of Module from the PSBoot endpoint
# Install the modules

# Start a Job with the PSBoot RestPS endpoint (Copy Routes?)
## RestPS -> PSBoot Endpoints
### Status -> Should return 'UP' if the application.ps1 ps process is running

# Start the application.ps1 file
## This file should be pretty straight forward and potentially start a user specified script?