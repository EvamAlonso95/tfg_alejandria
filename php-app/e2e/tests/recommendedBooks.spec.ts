import { test, expect } from "@playwright/test";
import { login } from "./utils";

test("booksRecommended", async ({ page }) => {
  await login("correoPrueba@example.com", "12345678+a", page);

  await page.goto("http://localhost/book?bookId=250");
  await page.getByRole("link", { name: "Añadir a la biblioteca" }).click();
  await page.goto("http://localhost/recommendedBook");
  await page.getByRole("heading", { name: "Matilda" }).click();
  await page.locator("a:nth-child(2)").first().click();
  await page.waitForSelector("#toastNotification");
  await page.click("#toastNotification button");

  await page.goto("http://localhost/book?bookId=248");
  await expect(page.getByRole("combobox")).toHaveValue("want to read");
  await page.click(".btn-delete-style");
  await page.waitForSelector("#toastNotification");
  await page.click("#toastNotification button");
});
