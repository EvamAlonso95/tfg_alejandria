<?php
enum BookUserStatus: string
{
	case wantToRead = 'want to read';
	case reading = 'reading';
	case read = 'read';
	case discarded = 'discarded';
}
