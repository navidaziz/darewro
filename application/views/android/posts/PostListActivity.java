
public class PostListActivity extends AppCompatActivity {
	
	static String[][] Items;
    private GoogleApiClient client;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_list_post);
		
		RequestQueue request_queue = Volley.newRequestQueue(PostListActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/post/view", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								 Items = new String[JsonArray.length()][7];
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									Items[i][0] = json_object.getString("post_title");
				Items[i][1] = json_object.getString("post_summary");
				Items[i][2] = json_object.getString("post_detail");
				Items[i][3] = json_object.getString("post_type");
				Items[i][4] = json_object.getString("image");
				Items[i][5] = json_object.getString("video_link");
				Items[i][6] = json_object.getString("post_keywords");
				
			
								}
								
								PostAdapter postAdapter;
                    			postAdapter = new PostAdapter(PostListActivity.this,Items);
                    			post_listView.setAdapter(postAdapter);
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							    Toast.makeText(PostListActivity, "Error in Json", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(PostListActivity, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);
		
		
		
 post_listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent i = new Intent(PostListActivity.this, PostView.class);
                i.putExtra("post_id", Items[position][0]);
                startActivity(i);
            }
        });
		
		

        
    }

}
