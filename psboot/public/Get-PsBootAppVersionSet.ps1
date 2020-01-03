function Get-PSbootAppVersionSet
{
    <#
    .DESCRIPTION
        Gathers PSboot System Data
    .PARAMETER Credential
        Credential used to access PSboot Rest Endpoint
    .PARAMETER SystemName
        Name of desired System
    .PARAMETER PSbootServer
        Configuration Server DNS name or IP
    .EXAMPLE
        Get-PSbootAppVersionSet -SystemName PRODUCTION -PSbootServer localhost
    .NOTES
        No notes at this time.
    #>
    [CmdletBinding(
        SupportsShouldProcess = $true,
        ConfirmImpact = "Low"
    )]
    [OutputType([String])]
    [OutputType([Boolean])]
    param(
        [Parameter()][String]$PSbootServer,
        [Parameter()][System.Management.Automation.PSCredential]$Credential,
        [Parameter()][String]$SystemName = "Production"
    )
    if ($pscmdlet.ShouldProcess("Starting Get-PSbootAppVersionSet function."))
    {
        try
        {
            # Update this to pull the application Name!
            $URI = "http://$PSbootServer/PSboot/api/index.php/application_versions?transform=true"
            (Invoke-RestMethod -Method Get -Uri $URI).application_versions
        }
        catch
        {
            $ErrorMessage = $_.Exception.Message
            $FailedItem = $_.Exception.ItemName
            Throw "Get-PSbootAppVersionSet: $ErrorMessage $FailedItem"
        }
    }
    else
    {
        # -WhatIf was used.
        return $false
    }
}