import { test, expect } from '@playwright/test';

test('addBookToLibrary', async ({ page }) => {
    await page.goto('http://localhost/user/login');


    await page.getByRole('textbox', { name: 'Correo electrónico' }).click();
    await page.getByRole('textbox', { name: 'Correo electrónico' }).fill('correoPrueba@example.com');
    await page.getByRole('textbox', { name: 'Contraseña' }).click();
    await page.getByRole('textbox', { name: 'Contraseña' }).fill('12345678+a');
    await page.getByRole('button', { name: 'Iniciar sesión' }).click();
    await page.goto('http://localhost/');
    await page.getByRole('textbox', { name: 'Buscar' }).click();
    await page.getByRole('textbox', { name: 'Buscar' }).fill('El principito');
    await page.getByRole('textbox', { name: 'Buscar' }).press('Enter');
    await page.getByRole('link', { name: 'El Principito' }).click();
    await page.getByRole('link', { name: 'Añadir a la biblioteca' }).click();
    await page.locator('div').filter({ hasText: 'Libro añadido a tu biblioteca' }).nth(2).click();
    await page.getByRole('button', { name: 'Cerrar' }).click();
    await page.goto('http://localhost/user/profile');
    await page.getByRole('tab', { name: 'Quiero leer' }).click();
    await page.getByRole('tabpanel', { name: 'Quiero leer' }).locator('div').first().click();
    await page.getByRole('link', { name: 'El Principito' }).click();
    await page.getByRole('link', { name: 'Eliminar de la biblioteca' }).click();
    await page.locator('div').filter({ hasText: 'Libro eliminado de la' }).nth(2).click();
});


test('changeBookStatus', async ({ page }) => {
    await page.goto('http://localhost/user/login');


    await page.getByRole('textbox', { name: 'Correo electrónico' }).click();
    await page.getByRole('textbox', { name: 'Correo electrónico' }).fill('correoPrueba@example.com');
    await page.getByRole('textbox', { name: 'Contraseña' }).click();
    await page.getByRole('textbox', { name: 'Contraseña' }).fill('12345678+a');
    await page.getByRole('button', { name: 'Iniciar sesión' }).click();
    await page.goto('http://localhost/');
    await page.getByRole('textbox', { name: 'Buscar' }).click();
    await page.getByRole('textbox', { name: 'Buscar' }).fill('El principito');
    await page.getByRole('textbox', { name: 'Buscar' }).press('Enter');
    await page.getByRole('link', { name: 'El Principito' }).click();
    await page.goto('http://localhost/user/profile');
    await page.getByRole('tab', { name: 'Quiero leer' }).click();
    await page.getByRole('tabpanel', { name: 'Quiero leer' }).locator('div').first().click();
    await page.getByRole('link', { name: 'El Principito' }).click();
    await expect(page.getByRole('combobox')).toHaveValue('want to read');
    await page.getByRole('combobox').selectOption('reading');
    await page.getByRole('button', { name: 'Guardar Estado' }).click();
    await page.getByText('Estado del libro actualizado').click();
    await page.locator('div').filter({ hasText: 'Estado del libro actualizado' }).nth(2).click();
    await page.getByRole('link', { name: 'Eliminar de la biblioteca' }).click();

});
