import { test, expect } from '@playwright/test';

test('checkLogoInHeader', async ({ page }) => {
    await page.goto('http://localhost/');
    await expect(page.getByRole('link', { name: 'Logo Alejandría' })).toBeVisible();
});

test('checkCookieBanner', async ({ page }) => {
    await page.goto('http://localhost/');
    await expect(page.locator('#cookieBanner')).toBeVisible();
    await page.getByRole('button', { name: 'Aceptar' }).click();
    await expect(page.locator('#cookieBanner')).not.toBeVisible();
});


test('register', async ({ page }) => {
    const id = crypto.randomUUID();
    await page.goto('http://localhost/');
    await page.getByRole('button', { name: 'Foto de perfil' }).click();
    await page.getByRole('link', { name: 'Registrarse' }).click();
    await page.getByRole('textbox', { name: 'Nombre de usuario' }).click();
    await page.getByRole('textbox', { name: 'Nombre de usuario' }).fill('Prueba-' + id);
    await page.getByRole('textbox', { name: 'Correo electrónico' }).click();
    await page.getByRole('textbox', { name: 'Correo electrónico' }).fill('correoPrueba' + id + '@example.com');
    await page.getByRole('textbox', { name: 'Contraseña', exact: true }).click();
    await page.getByRole('textbox', { name: 'Contraseña', exact: true }).fill('12345678+a');
    await page.getByRole('textbox', { name: 'Repite la contraseña' }).click();
    await page.getByRole('textbox', { name: 'Repite la contraseña' }).fill('12345678+a');
    await page.getByRole('button', { name: 'Regístrate' }).click();
    await expect(page.getByRole('alert')).toBeVisible();
    await expect(page.getByRole('alert')).toContainText('Registro completado correctamente');
});