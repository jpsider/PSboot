$script:ModuleName = 'psboot'

$here = (Split-Path -Parent $MyInvocation.MyCommand.Path) -replace 'tests', "$script:ModuleName"
$sut = (Split-Path -Leaf $MyInvocation.MyCommand.Path) -replace '\.Tests\.', '.'
. "$here\$sut"

$secpasswd = ConvertTo-SecureString "PlainTextPassword" -AsPlainText -Force
$Credential = New-Object System.Management.Automation.PSCredential ("FakeUser", $secpasswd)

Describe "Get-PsBootModVersionSet function for $script:ModuleName" -Tags Build {
    It "Should return False if -WhatIf is used." {
        Get-PsBootModVersionSet -Credential $Credential -PSBootServer "localhost" -SystemName "Prod" -WhatIf | Should be $false
    }
    It "Should not be null." {
        Mock -CommandName 'Invoke-RestMethod' -MockWith {
            $RawReturn = @(
                @{
                    ID        = '1'
                    MODULE_VERSION  = '11.4.0.14413515'
                    MODULE_ID  = '1'
                    STATUS_ID = '1'
                    date_modified = '2020-01-02 18:58:49'
                },
                @{
                    ID        = '2'
                    MODULE_VERSION  = '7.0.12'
                    MODULE_ID  = '2'
                    STATUS_ID = '2'
                    date_modified = '2020-01-02 18:58:49'
                }
            )
            $ReturnJson = $RawReturn | ConvertTo-Json
            $ReturnData = $ReturnJson | convertfrom-json
            return $ReturnData
        }
        Get-PsBootModVersionSet -Credential $Credential -PSBootServer "localhost" -SystemName "Prod" | Should not be $null
        Assert-MockCalled -CommandName 'Invoke-RestMethod' -Times 1 -Exactly
    }
    It "Should not Throw." {
        Mock -CommandName 'Invoke-RestMethod' -MockWith {
            $RawReturn = @(
                @{
                    ID        = '1'
                    MODULE_VERSION  = '11.4.0.14413515'
                    MODULE_ID  = '1'
                    STATUS_ID = '1'
                    date_modified = '2020-01-02 18:58:49'
                },
                @{
                    ID        = '2'
                    MODULE_VERSION  = '7.0.12'
                    MODULE_ID  = '2'
                    STATUS_ID = '2'
                    date_modified = '2020-01-02 18:58:49'
                }
            )
            $ReturnJson = $RawReturn | ConvertTo-Json
            $ReturnData = $ReturnJson | convertfrom-json
            return $ReturnData
        }
        {Get-PsBootModVersionSet -Credential $Credential -PSBootServer "localhost" -SystemName "Prod"} | Should not Throw
        Assert-MockCalled -CommandName 'Invoke-RestMethod' -Times 2 -Exactly
    }
    It "Should Throw when the rest call fails." {
        Mock -CommandName 'Invoke-RestMethod' -MockWith {
            Throw "Unable to reach server"
        }
        {Get-PsBootModVersionSet -Credential $Credential -PSBootServer "localhost" -SystemName "Prod"} | Should Throw
        Assert-MockCalled -CommandName 'Invoke-RestMethod' -Times 3 -Exactly
    }
}