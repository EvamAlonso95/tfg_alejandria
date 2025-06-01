import { test, expect } from '@playwright/test';

test('editUser', async ({ page }) => {
    await page.goto('http://localhost/');
    await page.getByRole('button', { name: 'Foto de perfil' }).click();
    await page.getByRole('link', { name: 'Iniciar sesión' }).click();
    await page.getByRole('textbox', { name: 'Correo electrónico' }).click();
    await page.getByRole('textbox', { name: 'Correo electrónico' }).fill('admin@admin.es');
    await page.getByRole('textbox', { name: 'Contraseña' }).click();
    await page.getByRole('textbox', { name: 'Contraseña' }).fill('alejandria25+');
    await page.getByRole('button', { name: 'Iniciar sesión' }).click();
    await page.getByRole('button', { name: 'Foto de perfil' }).click();
    await page.getByRole('link', { name: 'Panel de administración' }).click();
    await page.getByRole('row', { name: '2 mariana.rios89@example.com' }).getByRole('button').first().click();
    await page.getByLabel('Selecciona el rol').selectOption('1');
    await page.getByRole('button', { name: 'Actualizar' }).click();
    await page.locator('div').filter({ hasText: '¡Usuario actualizado' }).nth(2).click();

});


test('roles', async ({ page }) => {

   await page.goto('http://localhost/');
    await page.getByRole('button', { name: 'Foto de perfil' }).click();
    await page.getByRole('link', { name: 'Iniciar sesión' }).click();
    await page.getByRole('textbox', { name: 'Correo electrónico' }).click();
    await page.getByRole('textbox', { name: 'Correo electrónico' }).fill('admin@admin.es');
    await page.getByRole('textbox', { name: 'Contraseña' }).click();
    await page.getByRole('textbox', { name: 'Contraseña' }).fill('alejandria25+');
    await page.getByRole('button', { name: 'Iniciar sesión' }).click();
    await page.getByRole('button', { name: 'Foto de perfil' }).click();
    await page.getByRole('link', { name: 'Panel de administración' }).click();
  await page.getByRole('link', { name: 'Géneros' }).click();
  await page.getByRole('row', { name: '1 Ficción Editar Eliminar' }).getByRole('button').first().click();
  await page.getByRole('textbox', { name: 'Nombre' }).click();
  await page.getByRole('textbox', { name: 'Nombre' }).fill('Ficción12');
  await page.getByRole('button', { name: 'Actualizar' }).click();
  await page.locator('div').filter({ hasText: '¡Género guardado' }).nth(2).click();
  await page.getByRole('cell', { name: 'Ficción12' }).click();
  await page.getByRole('row', { name: 'Ficción12 Editar Eliminar' }).getByRole('button').first().click();
  await page.getByRole('textbox', { name: 'Nombre' }).click();
  await page.getByRole('textbox', { name: 'Nombre' }).fill('Ficción');
  await page.getByRole('button', { name: 'Actualizar' }).click();
  await page.locator('div').filter({ hasText: '¡Género guardado' }).nth(2).click();
  await page.getByRole('cell', { name: 'Ficción', exact: true }).click();
  await page.getByRole('button', { name: 'Crear' }).click();
  await page.getByRole('textbox', { name: 'Nombre' }).click();
  await page.getByRole('textbox', { name: 'Nombre' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Nombre' }).fill('PRUEBA');
  await page.getByLabel('Editar Género').getByRole('button', { name: 'Crear' }).click();
  await page.locator('div').filter({ hasText: '¡Género guardado' }).nth(2).click();
  await page.getByRole('button', { name: 'Id: Activate to invert sorting' }).click();
  await page.getByRole('cell', { name: 'PRUEBA' }).click();
  page.once('dialog', dialog => {
    console.log(`Dialog message: ${dialog.message()}`);
    dialog.dismiss().catch(() => {});
  });
  await page.getByRole('row', { name: 'PRUEBA Editar Eliminar' }).getByRole('button').nth(1).click();
  await page.locator('div').filter({ hasText: '¡Género eliminado' }).nth(2).click();
});


