import { Page } from "@playwright/test";

export async function login(username: string, password: string, page: Page) {
  console.log("Iniciando sesión...");
  await page.goto("http://localhost/user/login", {
    waitUntil: "domcontentloaded",
  });
  await page.getByRole("textbox", { name: "Correo electrónico" }).click();
  await page
    .getByRole("textbox", { name: "Correo electrónico" })
    .fill(username);
  await page.getByRole("textbox", { name: "Contraseña" }).click();
  await page.getByRole("textbox", { name: "Contraseña" }).fill(password);
  await page.getByRole("button", { name: "Iniciar sesión" }).click();
}
