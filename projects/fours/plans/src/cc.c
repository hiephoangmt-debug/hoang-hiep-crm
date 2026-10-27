#include <stdio.h>
#include <stdlib.h>
/* gán nhãn vùng liên thông 4 hướng cho mặt nạ nhị phân (stdin: W*H byte), stdout: W*H int32 */
static int *par;
static int fnd(int x){ while(par[x]!=x){ par[x]=par[par[x]]; x=par[x]; } return x; }
int main(int c,char**v){ int W=atoi(v[1]),H=atoi(v[2]); long N=(long)W*H; unsigned char*m=malloc(N); int*l=calloc(N,4); par=malloc(4*(N/2+2));
 fread(m,1,N,stdin); int n=1; par[0]=0;
 for(long i=0;i<N;i++){ if(!m[i]) continue; int x=i%W; int a=(x>0&&m[i-1])?l[i-1]:0, b=(i>=W&&m[i-W])?l[i-W]:0;
  if(!a&&!b){ par[n]=n; l[i]=n++; } else if(a&&b){ int ra=fnd(a),rb=fnd(b); l[i]=ra<rb?ra:rb; if(ra!=rb) par[ra>rb?ra:rb]=ra<rb?ra:rb; } else l[i]=a?a:b; }
 for(long i=0;i<N;i++) if(l[i]) l[i]=fnd(l[i]);
 fwrite(l,4,N,stdout); return 0; }
