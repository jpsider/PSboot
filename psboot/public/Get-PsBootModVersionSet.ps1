function Get-PSbootModVersionSet
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
        Get-PSbootModVersionSet -SystemName PRODUCTION -PSbootServer localhost
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
    if ($pscmdlet.ShouldProcess("Starting Get-PSbootModVersionSet function."))
    {
        try
        {
            # Update this to pull the Module Name!
            $URI = "http://$PSbootServer/PSboot/api/index.php/module_versions?transform=true"
            (Invoke-RestMethod -Method Get -Uri $URI).module_versions
        }
        catch
        {
            $ErrorMessage = $_.Exception.Message
            $FailedItem = $_.Exception.ItemName
            Throw "Get-PSbootModVersionSet: $ErrorMessage $FailedItem"
        }
    }
    else
    {
        # -WhatIf was used.
        return $false
    }
}