[System.Reflection.Assembly]::LoadWithPartialName('System.Windows.Forms') | Out-Null
[System.Windows.Forms.Application]::EnableVisualStyles()

# Création de la fenêtre
$form = New-Object System.Windows.Forms.Form
$form.Text = 'Git Commit'
$form.Size = New-Object System.Drawing.Size(400, 500)
$form.StartPosition = 'CenterScreen'

# Champ pour le nom du commit
$lblCommitName = New-Object System.Windows.Forms.Label
$lblCommitName.Text = 'Nom du commit:'
$lblCommitName.Location = New-Object System.Drawing.Point(10, 10)
$lblCommitName.AutoSize = $true
$form.Controls.Add($lblCommitName)

$txtCommitName = New-Object System.Windows.Forms.TextBox
$txtCommitName.Location = New-Object System.Drawing.Point(10, 30)
$txtCommitName.Size = New-Object System.Drawing.Size(360, 20)
$form.Controls.Add($txtCommitName)

# Champ pour la description
$lblDescription = New-Object System.Windows.Forms.Label
$lblDescription.Text = 'Description:'
$lblDescription.Location = New-Object System.Drawing.Point(10, 60)
$lblDescription.AutoSize = $true
$form.Controls.Add($lblDescription)

$txtDescription = New-Object System.Windows.Forms.TextBox
$txtDescription.Location = New-Object System.Drawing.Point(10, 80)
$txtDescription.Size = New-Object System.Drawing.Size(360, 60)
$txtDescription.Multiline = $true
$form.Controls.Add($txtDescription)

# Champ pour ajouter un changement
$lblChange = New-Object System.Windows.Forms.Label
$lblChange.Text = 'Changement effectué:'
$lblChange.Location = New-Object System.Drawing.Point(10, 150)
$lblChange.AutoSize = $true
$form.Controls.Add($lblChange)

$txtChange = New-Object System.Windows.Forms.TextBox
$txtChange.Location = New-Object System.Drawing.Point(10, 170)
$txtChange.Size = New-Object System.Drawing.Size(280, 20)
$form.Controls.Add($txtChange)

# Bouton pour ajouter un changement
$btnAddChange = New-Object System.Windows.Forms.Button
$btnAddChange.Text = 'Ajouter'
$btnAddChange.Location = New-Object System.Drawing.Point(300, 170)
$form.Controls.Add($btnAddChange)

# Liste des changements
$lstChanges = New-Object System.Windows.Forms.ListBox
$lstChanges.Location = New-Object System.Drawing.Point(10, 200)
$lstChanges.Size = New-Object System.Drawing.Size(360, 80)
$form.Controls.Add($lstChanges)

# Champ pour afficher le commit formaté
$lblPreview = New-Object System.Windows.Forms.Label
$lblPreview.Text = 'Aperçu du commit:'
$lblPreview.Location = New-Object System.Drawing.Point(10, 290)
$lblPreview.AutoSize = $true
$form.Controls.Add($lblPreview)

$txtPreview = New-Object System.Windows.Forms.TextBox
$txtPreview.Location = New-Object System.Drawing.Point(10, 310)
$txtPreview.Size = New-Object System.Drawing.Size(360, 80)
$txtPreview.Multiline = $true
$txtPreview.ReadOnly = $true
$form.Controls.Add($txtPreview)

# Bouton pour valider le commit
$btnCommit = New-Object System.Windows.Forms.Button
$btnCommit.Text = 'Valider Commit'
$btnCommit.Location = New-Object System.Drawing.Point(10, 400)
$form.Controls.Add($btnCommit)

# Ajouter un changement à la liste
$btnAddChange.Add_Click({
    if ($txtChange.Text -ne '') {
        $lstChanges.Items.Add($txtChange.Text)
        $txtChange.Text = ''
        UpdatePreview
    }
})

# Mettre à jour l'aperçu du commit
function UpdatePreview {
    $commitText = "Nom du commit: $($txtCommitName.Text)`n- Desc:" +
        ($txtDescription.Text -split '\n' | ForEach-Object {"`n  - $_"}) +
        "`n- Change:" +
        ($lstChanges.Items | ForEach-Object {"`n  - $_"})
    $txtPreview.Text = $commitText
}

$txtCommitName.Add_TextChanged({ UpdatePreview })
$txtDescription.Add_TextChanged({ UpdatePreview })

# Exécuter le commit Git
$btnCommit.Add_Click({
    $commitMessage = "`"$($txtCommitName.Text)`"`n- Desc:" +
        ($txtDescription.Text -split '\n' | ForEach-Object {"`n  - $_"}) +
        "`n- Change:" +
        ($lstChanges.Items | ForEach-Object {"`n  - $_"})

    git commit -m $commitMessage
    [System.Windows.Forms.MessageBox]::Show('Commit effectué!', 'Succès')
    $form.Close()
})

# Afficher la fenêtre
$form.ShowDialog()
