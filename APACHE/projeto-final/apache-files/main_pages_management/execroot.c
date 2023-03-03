#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <unistd.h>

int main()
{
setuid(0);
system("/projeto-final/apache-files/main_pages_management/reload_apache_and_dns.sh");
return 0;
}

