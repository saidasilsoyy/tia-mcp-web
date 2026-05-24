<?php

namespace App\Enums;

enum EntitlementCode: string
{
    case McpBasic = 'mcp.basic';
    case TiaRead = 'mcp.tia.read';
    case TiaWrite = 'mcp.tia.write';
    case GitLocal = 'mcp.git.local';
    case GitHubConnected = 'mcp.github.connected';
    case AdvancedPolicy = 'mcp.advanced.policy';
    case OfflineWindow = 'mcp.offline.window';
    case DesktopUpdates = 'desktop.updates';
}
