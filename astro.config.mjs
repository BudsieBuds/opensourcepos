// @ts-check
import { defineConfig } from 'astro/config';
import starlight from '@astrojs/starlight';

// https://astro.build/config
export default defineConfig({
	site: 'https://opensourcepos.org',
	integrations: [
		starlight({
			title: 'Open Source Point of Sale',
			logo: {
				light: './src/assets/logo.svg',
				dark: './src/assets/logo-white.svg',
				replacesTitle: true,
			},
			customCss: [
				'./src/styles/custom.css',
			],
			head: [
				{
					tag: 'script',
					content: `
						(() => {
							const openExternalLinksInNewTab = () => {
								const links = document.querySelectorAll('a[href^="http://"], a[href^="https://"]');
								const currentHost = window.location.host;
								for (const link of links) {
									try {
										const url = new URL(link.href, window.location.origin);
										if (url.host !== currentHost) {
											link.setAttribute('target', '_blank');
											link.setAttribute('rel', 'noopener noreferrer');
										}
									} catch {}
								}
							};
							if (document.readyState === 'loading') {
								document.addEventListener('DOMContentLoaded', openExternalLinksInNewTab);
							} else {
								openExternalLinksInNewTab();
							}
							document.addEventListener('astro:page-load', openExternalLinksInNewTab);
							document.addEventListener('click', (e) => {
								const link = e.target.closest('a');
								if (!link || !link.href) return;
								if (link.hostname && link.hostname !== window.location.hostname) {
									link.setAttribute('target', '_blank');
									link.setAttribute('rel', 'noopener noreferrer');
								}
							}, { capture: true });
						})();
					`,
				},
			],
			social: [
				{ icon: 'github', label: 'GitHub', href: 'https://github.com/opensourcepos/opensourcepos' },
				{ icon: 'matrix', label: 'Matrix Chat', href: 'https://matrix.to/#/#opensourcepos_Lobby:gitter.im' },
			],
			editLink: {
				baseUrl: 'https://github.com/opensourcepos/opensourcepos/edit/gh-pages/',
			},
			sidebar: [
				{
					label: 'Getting Started',
					items: [
						{ label: 'Overview & Requirements', slug: 'getting-started/overview' },
						{ label: 'Docker Quickstart', slug: 'getting-started/docker' },
						{ label: 'Traditional Server Install', slug: 'getting-started/installation' },
						{ label: 'Windows (XAMPP / WSL)', slug: 'getting-started/windows' },
						{ label: 'Raspberry Pi / SBC', slug: 'getting-started/raspberry-pi' },
						{ label: 'First Steps & Store Setup', slug: 'getting-started/first-steps' },
						{ label: 'Upgrading OSPOS', slug: 'getting-started/upgrading' },
					],
				},
				{
					label: 'User Guide',
					items: [
						{ label: 'Sales Register & Checkout', slug: 'user-guide/sales-register' },
						{ label: 'Sales Modes & Restaurant Service', slug: 'user-guide/sales-modes' },
						{ label: 'Items & Inventory', slug: 'user-guide/items-and-inventory' },
						{ label: 'Item Kits & Bundles', slug: 'user-guide/item-kits' },
						{ label: 'Item Attributes & Variants', slug: 'user-guide/item-attributes' },
						{ label: 'Receiving, POs & Stock Transfers', slug: 'user-guide/receiving-and-suppliers' },
						{ label: 'Customers, Loyalty & Store Credit', slug: 'user-guide/customers-and-due' },
						{ label: 'Gift Cards', slug: 'user-guide/gift-cards' },
						{ label: 'Cashups (Till Balancing) & Expenses', slug: 'user-guide/cashups-and-expenses' },
						{ label: 'Reports, Analytics & Exports', slug: 'user-guide/reports-and-analytics' },
						{ label: 'CSV Bulk Import Specification', slug: 'user-guide/csv-import-export' },
					],
				},
				{
					label: 'Hardware & Peripherals',
					items: [
						{ label: 'Hardware Compatibility Overview', slug: 'hardware/overview' },
						{ label: 'Thermal Receipt Printers (ESC/POS)', slug: 'hardware/receipt-printers' },
						{ label: 'Cash Drawers', slug: 'hardware/cash-drawers' },
						{ label: 'Barcode Scanners', slug: 'hardware/barcode-scanners' },
						{ label: 'Customer Pole Displays', slug: 'hardware/customer-displays' },
						{ label: 'Digital Scales & Weighted Barcodes', slug: 'hardware/scales-and-weighted-barcodes' },
					],
				},
				{
					label: 'Configuration & Management',
					items: [
						{ label: 'Store Information & General Settings', slug: 'configuration/store-settings' },
						{ label: 'Taxes & Tax Jurisdictions', slug: 'configuration/taxes' },
						{ label: 'Payment Methods & Gateways', slug: 'configuration/payment-gateways' },
						{ label: 'Employees, Roles & Permissions', slug: 'configuration/employees-and-permissions' },
						{ label: 'Localization, Currency & Decimals', slug: 'configuration/localization-and-currency' },
						{ label: 'Barcode & Price Label Setup', slug: 'configuration/barcode-labels' },
						{ label: 'Email, SMTP & Notifications', slug: 'configuration/email' },
						{ label: 'Security & Environment Hardening', slug: 'configuration/security-and-environment' },
					],
				},
				{
					label: 'Developer Documentation',
					items: [
						{ label: 'Architecture & CI4 Stack', slug: 'developer/architecture' },
						{ label: 'Local Development Environment', slug: 'developer/environment' },
						{ label: 'Database Schema & Migrations', slug: 'developer/database-and-migrations' },
						{ label: 'REST API & Endpoints', slug: 'developer/api' },
						{ label: 'Testing, Quality & CI Guidelines', slug: 'developer/testing-and-standards' },
						{ label: 'Localization & Crowdin Translations', slug: 'developer/translations' },
						{ label: 'Plugin & Extension System', slug: 'developer/plugins' },
					],
				},
				{
					label: 'FAQ & Troubleshooting',
					items: [
						{ label: 'Common Errors & Solutions', slug: 'troubleshooting/common-issues' },
						{ label: 'Printer & Cash Drawer Troubleshooting', slug: 'troubleshooting/printing' },
						{ label: 'Database & Migration Troubleshooting', slug: 'troubleshooting/database' },
						{ label: 'Backup & Disaster Recovery Runbook', slug: 'troubleshooting/backup-and-recovery' },
					],
				},
			],
		}),
	],
});
