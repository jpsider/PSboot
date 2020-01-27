# When the container starts up
# It needs to know whether to use a local file, or reach out to a PSBoot Server
$psBootPropertiesFile = "$env:SystemRoot/psboot/psboot.json"
if (Get-Item -Path $psBootPropertiesFile)
{
    # If it's a local file, read in the json, Get the list of Modules to Install
    $content = Get-Content -Path $psBootPropertiesFile | ConvertFrom-json
    $modulesToInstall = $content.Modules
    $psRepository = $content.PSRepository.Name
}
else
{
    # Else Get the SystemName,psbootAdmin server and get the list of Module from the PSBoot endpoints
    #TODO
}
# Set the PS Repository (if the Property exists in the return data)
if (($null -eq $psRepository) -or ($psRepository -eq "") -or ($psRepository -eq '$null'))
{
    # do not change the PSRepository
    Write-Host "Not Changing the PSRepository"
}
else
{
    # update the PS repository
    #TODO
}

Foreach ($module in $modulesToInstall)
{
    # Install the modules
    $ModuleName = $Module.Name
    $ModuleVersion = $Module.RequiredVersion
    Write-Host "Installing Module: $ModuleName Version: $ModuleVersion"
}

# Start a Job with the PSBoot RestPS endpoint
## RestPS -> PSBoot Endpoints (Copy the endpoints first)
Import-Module -Name psboot | Out-Null
$psBootModulebase = Get-Module -Name psboot | Select-Object -Property ModuleBase

$LocalDir = "$env:SystemRoot/psboot"
Write-Output "Creating psBoot Directories."
New-Item -Path "$LocalDir" -ItemType Directory -ErrorAction SilentlyContinue
New-Item -Path "$LocalDir/bin" -ItemType Directory
New-Item -Path "$LocalDir/endpoints" -ItemType Directory
New-Item -Path "$LocalDir/endpoints/Logs" -ItemType Directory
New-Item -Path "$LocalDir/endpoints/GET" -ItemType Directory
New-Item -Path "$LocalDir/endpoints/POST" -ItemType Directory
New-Item -Path "$LocalDir/endpoints/PUT" -ItemType Directory
New-Item -Path "$LocalDir/endpoints/DELETE" -ItemType Directory


$RoutesFileSource = $psBootModulebase + "/endpoints/RestPSRoutes.json"
Copy-Item -Path "$RoutesFileSource" -Destination "$LocalDir/endpoints" -Confirm:$false -Force
$EndpointVerbs = @("GET", "POST", "PUT", "DELETE")
foreach ($Verb in $EndpointVerbs)
{
    $endpointsource = $SourceDir + "/endpoints/$Verb"
    Write-Output "Copying $endpointsource to Desination $LocalDir/endpoints/$Verb"
    Copy-Item -Path "$endpointsource" -Recurse -Destination "$LocalDir/endpoints/$Verb" -Confirm:$false -Force
}
$routesFile = "$localDir/endpoints/RestPSRoutes.json"
Start-job -ScriptBlock { Start-RestPSListener -RoutesFilePath $routesFile -Port 8080 }

### Status/info/getroutes -> Should return 'UP' if the application.ps1 ps process is running

# Start the application.ps1 file
$runapp = $true
do
{
    try
    {
        Start-Process -NoNewWindow -FilePath "$env:SystemRoot/psboot/application.ps1"
    }
    catch
    {
        Write-Output "The application.ps1 script failed, Restarting it!"
    }
} while ($runapp -eq $true)