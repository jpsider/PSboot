function Get-PSbootApplicationSet
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
        Get-PSbootModuleSet -SystemName PRODUCTION -PSbootServer localhost
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
    if ($pscmdlet.ShouldProcess("Starting Get-PSbootApplicationSet function."))
    {
        try
        {
            $URI = "http://$PSbootServer/PSboot/api/index.php/applications?transform=true"
            (Invoke-RestMethod -Method Get -Uri $URI).applications
        }
        catch
        {
            $ErrorMessage = $_.Exception.Message
            $FailedItem = $_.Exception.ItemName
            Throw "Get-PSbootModuleSet: $ErrorMessage $FailedItem"
        }
    }
    else
    {
        # -WhatIf was used.
        return $false
    }
}