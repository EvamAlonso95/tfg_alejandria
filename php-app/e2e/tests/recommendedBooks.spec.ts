import { test, expect } from '@playwright/test';

test('recommendedBook', async ({ page }) => {
  await page.goto('http://localhost/user/login');


  await page.getByRole('textbox', { name: 'Correo electrónico' }).click();
  await page.getByRole('textbox', { name: 'Correo electrónico' }).fill('correoPrueba@example.com');
  await page.getByRole('textbox', { name: 'Contraseña' }).click();
  await page.getByRole('textbox', { name: 'Contraseña' }).fill('alejandria25+');
  await page.getByRole('button', { name: 'Iniciar sesión' }).click();
  await page.getByRole('link', { name: 'Descubre más lecturas' }).click();
  await page.locator('a:nth-child(2)').first().click();
  await page.getByText('Libro añadido a tu biblioteca').click();
});

